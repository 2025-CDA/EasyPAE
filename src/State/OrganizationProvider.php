<?php
// src/State/OrganizationProvider.php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\OrganizationDTO;
use App\Repository\OrganizationRepository;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ApiPlatform\Metadata\CollectionOperationInterface;

class OrganizationProvider implements ProviderInterface
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
        private readonly TrainingSessionRepository $trainingSessionRepository
    ) {
    }


public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
{
    if ($operation instanceof CollectionOperationInterface) {
        // Récupérer toutes les sessions
        $sessions = $this->trainingSessionRepository->findAll();
        $dtos = [];
        foreach ($sessions as $session) {
            $dto = new OrganizationDTO();
            $dto->id = $session->getId();
            $dto->name = $session->getTraining()?->getName();
            $dto->offerNumber = $session->getOfferNumber();
            $dto->startDate = $session->getTrainingPeriodStart();
            $dto->endDate = $session->getTrainingPeriodEnd();
            $dtos[] = $dto;
        }
        return $dtos;
    }

    // Cas item
    if (isset($uriVariables['id'])) {
        $session = $this->trainingSessionRepository->find((int) $uriVariables['id']);
        if (!$session) {
            // Option 1 : lancer explicitement l’exception
            throw new NotFoundHttpException('Training session not found.');
            // Option 2 : return null; // Api Platform gère la 404
        }
        $dto = new OrganizationDTO();
        $dto->id = $session->getId();
        $dto->name = $session->getTraining()?->getName();
        $dto->offerNumber = $session->getOfferNumber();
        $dto->startDate = $session->getTrainingPeriodStart();
        $dto->endDate = $session->getTrainingPeriodEnd();
        return $dto;
    }

    return null; // Aucun cas traité
}
}
