<?php
// src/State/OrganizationProvider.php

namespace App\State;

// Importation des classes et interfaces nécessaires.
use App\Dto\OrganizationDTO;

// DTO pour structurer les données retournées
use Doctrine\ORM\Cache\Region;

// (semble inutile ici, probablement un reste d'import)
use ApiPlatform\Metadata\Operation;

// base pour la gestion d'opération API Platform
use App\Repository\InfoFormRepository;

// Accès aux entités InfoForm
use ApiPlatform\State\ProviderInterface;

// Interface à implémenter pour fournir des données custom
use App\Repository\OrganizationRepository;

// Accès aux organisations
use App\Repository\TrainingSessionRepository;

// Accès aux sessions de formation
use ApiPlatform\Metadata\CollectionOperationInterface;

// Pour savoir si l'opération vise une collection
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// Pour lancer une erreur 404 si entité non trouvée

// Déclare la classe Provider qui va servir à personnaliser la manière dont une ressource est exposée via l'API.
class OrganizationProvider implements ProviderInterface
{
    // Injection des repositories nécessaires dans le constructeur
    public function __construct(
        private readonly OrganizationRepository    $organizationRepository,
        private readonly TrainingSessionRepository $trainingSessionRepository,
        private readonly InfoFormRepository        $infoFormRepository, // ajouté
    )
    {
    }

    // Cette méthode doit toujours retourner un object, un array ou null selon la déclaration.
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
//         On vérifie si l'opération reçue porte sur une collection (plusieurs éléments)
        if ($operation instanceof CollectionOperationInterface) {
//            // Cas où l'URL contient un paramètre 'sessionId', donc on filtre par session

//           route /organization/session/{sessionId}/interns
            if (isset($uriVariables['sessionId'])) {
                // Recherche la session de formation demandée
                $session = $this->trainingSessionRepository->find((int)$uriVariables['sessionId']);
                // Si elle n'existe pas, on lève une exception HTTP 404
                if (!$session) {
                    throw new NotFoundHttpException('Training session not found.');
                }

                // On récupère tous les stagiaires associés à la session
                $interns = $session->getInfoForms()->first()->getInternMember();
                $dtos = []; // On prépare un tableau pour stocker les DTOs
                foreach ($interns as $intern) {
                    $dto = new OrganizationDTO(); // Crée un nouvel objet DTO pour le stagiaire
                    $dto->sessionId = $session->getId();
                    $dto->internFirstName = $intern->getUser()?->getFirstName();
                    $dto->internLastName = $intern->getUser()?->getLastName();
                    $dto->internLogin = $intern->getUser()?->getLogin();

                    // Recherche dans InfoForm si un formulaire existe pour ce stagiaire et cette session
                    $infoForm = $this->infoFormRepository->findOneBy([
                        'internMember' => $intern,
                        'trainingSession' => $session,
                    ]);

                    // Si on trouve un formulaire, récupère son statut, sinon laisse à null
                    if ($infoForm !== null) {
                        $status = $infoForm->getStatus();
                        // Si le statut est un ENUM (objet), tente de récupérer sa valeur ou son nom
                        if (is_object($status)) {
                            $dto->infoFormStatus = $status->value ?? $status->name ?? (method_exists($status, '__toString') ? (string)$status : null);
                        } else {
                            $dto->infoFormStatus = $status !== null ? (string)$status : null;
                        }
                    } else {
                        $dto->infoFormStatus = null;
                    }
                    $dtos[] = $dto; // Ajoute le DTO au tableau
                }
                return $dtos; // On retourne la liste des DTOs des stagiaires pour la session
            }
        }

        // Cas où on demande un item (spécifique), cherche par sessionId ou par id
//          route /organization/session/{sessionId}
        $itemId = $uriVariables['sessionId'] ?? $uriVariables['id'] ?? null;
        if ($itemId !== null) {
            // Recherche la session demandée
            $session = $this->trainingSessionRepository->find((int)$itemId);
            if (!$session) {
                throw new NotFoundHttpException('Training session not found.');
            }
            $dto = new OrganizationDTO(); // Crée un DTO pour la session
            $dto->sessionId = $session->getId();
            $dto->name = $session->getTraining()?->getName();
            $dto->offerNumber = $session->getOfferNumber();
            $dto->startDate = $session->getInternShipPeriodStart(); // Attention à l'orthographe : InternShip
            $dto->endDate = $session->getInternshipPeriodEnd();
            return $dto; // Retourne le DTO de la session spécifique
        }
        // Si aucun des cas n'a abouti, retourne null explicitement
        return null;
    }

}
