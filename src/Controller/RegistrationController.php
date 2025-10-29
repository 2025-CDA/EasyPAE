<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EmailService $emailService
    ) {}

    #region Registration GET (pour affichage du formulaire Twig) - A SUPPRIMER APRESS LES TESTS
    #[Route('/registration', name: 'registration', methods: ['GET'])]
    public function registrationForm(): Response
    {
        return $this->render('pages/registration.html.twig');
    }
    #endregion

    #region Registration POST
    #[Route('/registration', name: 'registration_process', methods: ['POST'])]
    public function registrationProcess(Request $request): Response
    {
        // ========================================
        // ÉTAPE 1 : Récupération des données du formulaire
        // ========================================
        // Récupère les valeurs des champs envoyés par le formulaire HTML
        $firstName = $request->request->get('first_name');
        $lastName = $request->request->get('last_name');
        $email = $request->request->get('email');

        // ========================================
        // ÉTAPE 2 : Validation des données
        // ========================================
        // Vérifie que tous les champs obligatoires sont remplis
        if (!$firstName || !$lastName || !$email) {
            // Si un champ manque, on ré-affiche le formulaire avec un message d'erreur
            return $this->render('pages/registration.html.twig', [
                'error' => 'Tous les champs sont requis'
            ]);
        }

        // ========================================
        // ÉTAPE 3 : Vérification de l'unicité de l'email
        // ========================================
        // Cherche dans la base si un utilisateur existe déjà avec cet email
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        
        // Si l'email existe déjà, on refuse l'inscription
        if ($existingUser) {
            return $this->render('pages/registration.html.twig', [
                'error' => 'Un utilisateur avec cet email existe déjà'
            ]);
        }

        // ========================================
        // ÉTAPE 4 : Création du nouvel utilisateur
        // ========================================
        // Crée une nouvelle instance de l'entité User
        $user = new User();
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        
        // IMPORTANT : isFirstConnection reste à false jusqu'à ce que l'utilisateur
        // définisse son mot de passe. Il passera à true dans SecurityController
        // lors de la validation du mot de passe via le lien d'activation
        $user->setIsFirstConnection(false);
        
        // SÉCURITÉ : Le mot de passe est vide au départ. Cela empêche toute connexion
        // tant que l'utilisateur n'a pas cliqué sur le lien d'activation et défini
        // son mot de passe. La vérification empty($user->getPassword()) dans le 
        // SecurityController bloque explicitement ces tentatives de connexion
        $user->setPassword('');

        // ========================================
        // ÉTAPE 5 : Sauvegarde en base de données
        // ========================================
        // persist() : Prépare l'objet pour l'insertion en BDD
        $this->entityManager->persist($user);
        // flush() : Exécute réellement la requête SQL INSERT
        $this->entityManager->flush();

        // ========================================
        // ÉTAPE 6 : Génération du token d'activation
        // ========================================
        // Génère un token aléatoire sécurisé de 32 caractères hexadécimaux
        // random_bytes(16) = 16 octets = 128 bits de sécurité
        // bin2hex() convertit en hexadécimal (32 caractères)
        // Préfixe 'NEW_' permet de distinguer les tokens de création des tokens de reset
        $token = 'NEW_' . bin2hex(random_bytes(16));
        
        // ========================================
        // ÉTAPE 7 : Stockage du token en session
        // ========================================
        // Stocke le token en session avec les infos associées
        // Clé : 'reset_token_' + le token généré
        // Valeur : array contenant l'ID utilisateur et la date d'expiration
        $request->getSession()->set('reset_token_' . $token, [
            'user_id' => $user->getId(),           // ID de l'utilisateur pour le retrouver
            'expires' => time() + 86400            // Expire dans 24h (86400 secondes)
        ]);

        // ========================================
        // ÉTAPE 8 : Construction du lien d'activation
        // ========================================
        // getSchemeAndHttpHost() retourne l'URL de base (ex: http://localhost:8000)
        // On concatène avec '/reset-password/' et le token
        // Résultat : http://localhost:8000/reset-password/NEW_abc123def456...
        $updatePasswordLink = $request->getSchemeAndHttpHost() . '/reset-password/' . $token;
        
        // ========================================
        // ÉTAPE 9 : Envoi de l'email d'activation
        // ========================================
        // Utilise le service EmailService pour envoyer l'email
        // L'email contient le lien d'activation que le stagiaire devra cliquer
        $this->emailService->sendRegistrationEmail($user, $updatePasswordLink);

        // ========================================
        // ÉTAPE 10 : Affichage du message de succès
        // ========================================
        // Ré-affiche le formulaire avec un message de confirmation
        // Le template vérifie la variable 'success' pour afficher le bon message
        return $this->render('pages/registration.html.twig', [
            'success' => true
        ]);
    }
    #endregion
}