<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** COMPOSANT POUR TEST UNIQUEMENT _ A SUPP APRES TEST **/
#[Route('/email', name: 'email_')]
class MailerController extends AbstractController
{
    public function __construct(
        private EmailService $emailService,
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Envoie un email de bienvenue
     * TEST : curl -X POST http://localhost:8000/email/welcome/1
     */
    #[Route('/welcome/{userId}', name: 'welcome', methods: ['POST'])]
    public function sendWelcome(int $userId): JsonResponse
    {
        // Récupère l'utilisateur en base
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }

        try {
            // Appelle le service d'email pour envoyer un email de bienvenue
            $this->emailService->sendWelcomeEmail(
                $user->getEmail(),
                'Bienvenue sur EasyPAE',
                $user->getFirstName() . ' ' . $user->getLastName()
            );
            
            return new JsonResponse([
                'message' => 'Email de bienvenue envoyé',
                'recipient' => $user->getEmail()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Envoie un email de notification
     * TEST : curl -X POST http://localhost:8000/email/notification/1
     */
    #[Route('/notification/{userId}', name: 'notification', methods: ['POST'])]
    public function sendNotification(int $userId): JsonResponse
    {
        // Récupère l'utilisateur en base
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }

        try {
            // Appelle le service d'email pour envoyer une notification
            $this->emailService->sendNotificationEmail(
                $user->getEmail(),
                'Notification importante',
                $user->getFirstName() . ' ' . $user->getLastName(),
                'Ceci est un message de test pour la notification.'
            );
            
            return new JsonResponse([
                'message' => 'Email de notification envoyé',
                'recipient' => $user->getEmail()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Envoie un email de confirmation de soumission de formulaire
     * TEST : curl -X POST http://localhost:8000/email/form-submitted/1
     */
    #[Route('/form-submitted/{userId}', name: 'form_submitted', methods: ['POST'])]
    public function sendFormSubmitted(int $userId): JsonResponse
    {
        // Récupère l'utilisateur en base
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }

        try {
            // Données de test du formulaire
            $formData = [
                'nom' => 'Dupont',
                'prenom' => 'Jean',
                'entreprise' => 'TechCorp',
                'date_debut' => '2025-11-01'
            ];

            // Appelle le service d'email avec les données du formulaire
            $this->emailService->sendFormSubmittedEmail(
                $user->getEmail(),
                'Formulaire soumis avec succès',
                $user->getFirstName() . ' ' . $user->getLastName(),
                $formData
            );
            
            return new JsonResponse([
                'message' => 'Email de formulaire envoyé',
                'recipient' => $user->getEmail()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Envoie un email d'activation de compte (nouveau stagiaire)
     * TEST : curl -X POST http://localhost:8000/email/registration/1
     */
    #[Route('/registration/{userId}', name: 'registration', methods: ['POST'])]
    public function sendRegistration(int $userId): JsonResponse
    {
        // Récupère l'utilisateur en base
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }

        try {
            // Génère un token factice pour le test (en production, utiliser le vrai système de tokens)
            $token = 'NEW_' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
            $updatePasswordLink = 'http://127.0.0.1:8000/set-password/' . $token;
            
            // Appelle le service d'email pour envoyer l'email d'activation
            $this->emailService->sendRegistrationEmail($user, $updatePasswordLink);
            
            return new JsonResponse([
                'message' => 'Email de création de compte envoyé',
                'recipient' => $user->getEmail(),
                'token' => $token // DEBUG UNIQUEMENT - À retirer en prod
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Envoie un email de réinitialisation de mot de passe
     * TEST : curl -X POST http://localhost:8000/email/password-reset/1
     */
    #[Route('/password-reset/{userId}', name: 'password_reset', methods: ['POST'])]
    public function sendPasswordReset(int $userId): JsonResponse
    {
        // Récupère l'utilisateur en base
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }

        try {
            // Génère un token factice pour le test (en production, utiliser le vrai système de tokens)
            $resetToken = 'RESET_' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
            $resetPasswordLink = 'http://127.0.0.1:8000/reset-password/' . $resetToken;
            
            // Appelle le service d'email pour envoyer l'email de réinitialisation
            $this->emailService->sendResetPasswordEmail($user, $resetPasswordLink);
            
            return new JsonResponse([
                'message' => 'Email de réinitialisation envoyé',
                'recipient' => $user->getEmail(),
                'resetToken' => $resetToken // DEBUG 
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }

}