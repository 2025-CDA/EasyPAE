<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private EmailService $emailService
    ) {}


    #region Login GET - A SUPP APRED TEST
    #[Route('/login', name: 'login', methods: ['GET'])]
    public function loginForm(): Response
    {
        return $this->render('pages/login.html.twig');
    }
    #endregion

    #region Login POST
    #[Route('/login', name: 'login_process', methods: ['POST'])]
    public function loginProcess(Request $request, SessionInterface $session): Response
    {
        // ========================================
        // ÉTAPE 1 : Récupération des données du formulaire
        // ========================================
        // Récupère les valeurs des champs email et password envoyés par le formulaire HTML
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // ========================================
        // ÉTAPE 2 : Validation de présence des données
        // ========================================
        // Vérifie que les deux champs obligatoires sont remplis
        if (!$email || !$password) {
            // Si un champ manque, on ré-affiche le formulaire avec un message d'erreur
            return $this->render('pages/login.html.twig', [
                'error' => 'Email et mot de passe sont requis'
            ]);
        }

        // ========================================
        // ÉTAPE 3 : Recherche de l'utilisateur en base
        // ========================================
        // Cherche dans la base un utilisateur avec l'email fourni
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        // ========================================
        // ÉTAPE 4 : Vérification de l'existence et du mot de passe défini
        // ========================================
        // SÉCURITÉ CRITIQUE : Vérification explicite que l'utilisateur a un mot de passe défini
        // Cela empêche la connexion sur les comptes créés mais non activés (password vide)
        // Message d'erreur volontairement générique pour ne pas révéler si l'email existe
        if (!$user || empty($user->getPassword())) {
            return $this->render('pages/login.html.twig', [
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }

        // ========================================
        // ÉTAPE 5 : Validation du mot de passe
        // ========================================
        // isPasswordValid() compare le mot de passe en clair avec le hash stocké en base
        // Utilise l'algorithme de hashage sécurisé configuré dans Symfony (bcrypt par défaut)
        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            return $this->render('pages/login.html.twig', [
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }

        // ========================================
        // ÉTAPE 6 : Création de la session utilisateur
        // ========================================
        // Stocke les informations de l'utilisateur en session pour le garder connecté
        $session->set('user_email', $user->getEmail());  // Email pour affichage
        $session->set('user_id', $user->getId());        // ID pour récupérer les données

        // ========================================
        // ÉTAPE 7 : Redirection vers la page d'accueil
        // ========================================
        // Connexion réussie : redirige vers la page home
        return $this->redirectToRoute('home');
    }
    #endregion

    #region Logout
    #[Route('/logout', name: 'logout', methods: ['POST'])]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('home');
    }
    #endregion

    #region Forgot Password GET
    #[Route('/forgot-password', name: 'forgot_password', methods: ['GET'])]
    public function forgotPasswordForm(): Response
    {
        return $this->render('pages/forgot_password.html.twig');
    }

    #[Route('/forgot-password', name: 'forgot_password_process', methods: ['POST'])]
    public function forgotPasswordProcess(Request $request): Response
    {
        // ========================================
        // ÉTAPE 1 : Récupération de l'email
        // ========================================
        // Récupère l'email saisi dans le formulaire
        $email = $request->request->get('email');

        // ========================================
        // ÉTAPE 2 : Validation de présence de l'email
        // ========================================
        // Vérifie que le champ email est rempli
        if (!$email) {
            return $this->render('pages/forgot_password.html.twig', [
                'error' => 'Email requis'
            ]);
        }

        // ========================================
        // ÉTAPE 3 : Recherche de l'utilisateur
        // ========================================
        // Cherche dans la base un utilisateur avec cet email
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        // Si l'utilisateur n'existe pas, affiche une erreur
        if (!$user) {
            return $this->render('pages/forgot_password.html.twig', [
                'error' => 'Aucun utilisateur trouvé avec cet email'
            ]);
        }

        // ========================================
        // ÉTAPE 4 : Génération du token de réinitialisation
        // ========================================
        // Génère un token aléatoire sécurisé de 32 caractères hexadécimaux
        // random_bytes(16) = 16 octets = 128 bits de sécurité
        // bin2hex() convertit en hexadécimal (32 caractères)
        // Préfixe 'RESET_' permet de distinguer les tokens de reset des tokens d'activation
        $resetToken = 'RESET_' . bin2hex(random_bytes(16));
        
        // ========================================
        // ÉTAPE 5 : Stockage du token en session
        // ========================================
        // Stocke le token en session avec les infos associées
        // Clé : 'reset_token_' + le token généré
        // Valeur : array contenant l'ID utilisateur et la date d'expiration
        $request->getSession()->set('reset_token_' . $resetToken, [
            'user_id' => $user->getId(),      // ID de l'utilisateur pour le retrouver
            'expires' => time() + 3600        // Expire dans 1h (3600 secondes)
        ]);

        // ========================================
        // ÉTAPE 6 : Construction du lien de réinitialisation
        // ========================================
        // getSchemeAndHttpHost() retourne l'URL de base (ex: http://localhost:8000)
        // On concatène avec '/reset-password/' et le token
        // Résultat : http://localhost:8000/reset-password/RESET_abc123def456...
        $resetPasswordLink = $request->getSchemeAndHttpHost() . '/reset-password/' . $resetToken;
        
        // ========================================
        // ÉTAPE 7 : Envoi de l'email de réinitialisation
        // ========================================
        // Utilise le service EmailService pour envoyer l'email
        // L'email contient le lien de réinitialisation sur lequel l'utilisateur devra cliquer
        $this->emailService->sendResetPasswordEmail($user, $resetPasswordLink);

        // ========================================
        // ÉTAPE 8 : Affichage du message de confirmation
        // ========================================
        // Ré-affiche le formulaire avec un message de confirmation
        // Le template vérifie la variable 'success' pour afficher le bon message
        return $this->render('pages/forgot_password.html.twig', [
            'success' => true
        ]);
    }
    #endregion

    #region Reset Password - GET
    #[Route('/reset-password/{token}', name: 'reset_password', methods: ['GET'])]
    public function resetPasswordForm(string $token, Request $request): Response
    {
        // ========================================
        // ÉTAPE 1 : Récupération des données du token depuis la session
        // ========================================
        // Cherche dans la session les données associées à ce token
        $tokenData = $request->getSession()->get('reset_token_' . $token);
        
        // ========================================
        // ÉTAPE 2 : Validation du token
        // ========================================
        // Vérifie que le token existe ET n'est pas expiré
        // $tokenData['expires'] contient le timestamp d'expiration
        // time() retourne le timestamp actuel
        if (!$tokenData || $tokenData['expires'] < time()) {
            // Token invalide ou expiré : affiche une erreur
            return $this->render('pages/reset_password.html.twig', [
                'token' => $token,
                'error' => 'Token invalide ou expiré'
            ]);
        }

        // ========================================
        // ÉTAPE 3 : Affichage du formulaire
        // ========================================
        // Token valide : affiche le formulaire de réinitialisation
        return $this->render('pages/reset_password.html.twig', [
            'token' => $token
        ]);
    }


    #[Route('/reset-password/{token}', name: 'reset_password_process', methods: ['POST'])]
    public function resetPasswordProcess(string $token, Request $request, SessionInterface $session): Response
    {
        // ========================================
        // ÉTAPE 1 : Récupération des données du formulaire
        // ========================================
        // Récupère les deux champs de mot de passe (saisie et confirmation)
        $password = $request->request->get('password');
        $passwordConfirm = $request->request->get('password_confirm');

        // ========================================
        // ÉTAPE 2 : Validation de présence des champs
        // ========================================
        // Vérifie que les deux champs sont remplis
        if (!$password || !$passwordConfirm) {
            return $this->render('pages/reset_password.html.twig', [
                'token' => $token,
                'error' => 'Tous les champs sont requis'
            ]);
        }

        // ========================================
        // ÉTAPE 3 : Vérification de correspondance des mots de passe
        // ========================================
        // Vérifie que les deux mots de passe saisis sont identiques
        if ($password !== $passwordConfirm) {
            return $this->render('pages/reset_password.html.twig', [
                'token' => $token,
                'error' => 'Les mots de passe ne correspondent pas'
            ]);
        }

        // ========================================
        // ÉTAPE 4 : Récupération et validation du token
        // ========================================
        // Récupère les données du token depuis la session
        $tokenData = $request->getSession()->get('reset_token_' . $token);
        
        // Vérifie que le token existe ET n'est pas expiré
        if (!$tokenData || $tokenData['expires'] < time()) {
            return $this->render('pages/reset_password.html.twig', [
                'token' => $token,
                'error' => 'Token invalide ou expiré'
            ]);
        }

        // ========================================
        // ÉTAPE 5 : Récupération de l'utilisateur
        // ========================================
        // Récupère l'utilisateur depuis la BDD en utilisant l'ID stocké dans le token
        $user = $this->entityManager->getRepository(User::class)->find($tokenData['user_id']);
        
        // Vérifie que l'utilisateur existe toujours en base
        if (!$user) {
            return $this->render('pages/reset_password.html.twig', [
                'token' => $token,
                'error' => 'Utilisateur non trouvé'
            ]);
        }

        // ========================================
        // ÉTAPE 6 : Hashage et sauvegarde du nouveau mot de passe
        // ========================================
        // hashPassword() utilise bcrypt (ou l'algorithme configuré) pour hasher le mot de passe
        // Le hash généré est une chaîne d'environ 60 caractères, sécurisée et non réversible
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        
        // ========================================
        // ÉTAPE 7 : Activation complète du compte
        // ========================================
        // IMPORTANT : isFirstConnection passe à true UNIQUEMENT maintenant
        // Cela indique que l'utilisateur a défini son mot de passe et activé son compte
        // Dans RegistrationController, il était à false (compte créé mais non activé)
        $user->setIsFirstConnection(true);
        
        // flush() : Exécute les requêtes SQL UPDATE pour sauvegarder les changements
        $this->entityManager->flush();

        // ========================================
        // ÉTAPE 8 : Suppression du token de la session
        // ========================================
        // Le token a été utilisé, on le supprime pour qu'il ne puisse plus être réutilisé
        $request->getSession()->remove('reset_token_' . $token);

        // ========================================
        // ÉTAPE 9 : Connexion automatique de l'utilisateur
        // ========================================
        // Crée une session pour l'utilisateur (connexion automatique après réinitialisation)
        $session->set('user_email', $user->getEmail());
        $session->set('user_id', $user->getId());

        // ========================================
        // ÉTAPE 10 : Affichage du message de succès
        // ========================================
        // Affiche le formulaire avec un message de confirmation
        // L'utilisateur est maintenant connecté et son compte est actif
        return $this->render('pages/reset_password.html.twig', [
            'token' => $token,
            'success' => true
        ]);
    }
    #endregion
}
