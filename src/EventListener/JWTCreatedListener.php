<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Listener qui personnalise le payload du token JWT lors de sa création
 * 
 * Ce listener s'exécute automatiquement quand un utilisateur se connecte via l'API
 * (POST /api/login_check) et permet d'ajouter des données personnalisées au token.
 * 
 * Utilité pour React :
 * - React peut récupérer l'ID utilisateur sans appel API supplémentaire
 * - React peut afficher le nom complet directement depuis le token
 * - Permet de tracer l'IP de connexion pour la sécurité
 */
final class JWTCreatedListener
{
    public function __construct(
        private readonly RequestStack $requestStack
    ) {}

    /**
     * Personnalise le payload du JWT avant qu'il ne soit signé et envoyé au client
     * 
     * S'exécute automatiquement lors de la création du token (après authentification réussie)
     */
    #[AsEventListener(event: 'lexik_jwt_authentication.on_jwt_created')]
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        // ========================================
        // ÉTAPE 1 : Récupération de la requête HTTP
        // ========================================
        $request = $this->requestStack->getCurrentRequest();

        // Sécurité : Si le listener est appelé hors contexte HTTP, on ne fait rien
        if (null === $request) {
            return;
        }

        // ========================================
        // ÉTAPE 2 : Récupération du payload et de l'utilisateur
        // ========================================
        // Récupère le payload JWT actuel (contenu par défaut)
        $payload = $event->getData();
        
        // Récupère l'utilisateur authentifié
        $user = $event->getUser();

        // Vérification que l'utilisateur est bien une instance de notre entité User
        if (!$user instanceof User) {
            return;
        }

        // ========================================
        // ÉTAPE 3 : Personnalisation du payload
        // ========================================
        
        // SUPPRESSION de la clé "username" (on va utiliser "email" à la place)
        unset($payload['username']);

        // AJOUT de données personnalisées
        $payload['id'] = $user->getId();                    // ID utilisateur (utile pour React)
        $payload['email'] = $user->getUserIdentifier();     // Email explicite
        $payload['firstName'] = $user->getFirstName();      // Prénom
        $payload['lastName'] = $user->getLastName();        // Nom
        $payload['fullName'] = $user->getFirstName() . ' ' . $user->getLastName(); // Nom complet
        $payload['isFirstConnection'] = $user->isFirstConnection(); // Première connexion ?
        $payload['intern_member_id'] = $user->getInternMember()?->getId();
        $payload['company_member_id'] = $user->getCompanyMember()?->getId();
        $payload['organization_member_id'] = $user->getOrganizationMember()?->getId();

        // RÔLES : Ajout explicite des rôles de l'utilisateur pour la gestion des permissions
        // Important pour que React sache si l'utilisateur est admin, organisme, stagiaire, etc.
        $payload['roles'] = $user->getRoles();
        
        // TRAÇABILITÉ : Ajout de l'IP de connexion (utile pour l'audit de sécurité)
        $payload['ip'] = $request->getClientIp();

        // ========================================
        // ÉTAPE 4 : Application des modifications
        // ========================================
        // Met à jour le payload du JWT avec nos modifications
        $event->setData($payload);
    }
}
