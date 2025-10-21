<?php
// src/State/OrganizationProvider.php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\OrganizationDTO;
use App\Repository\OrganizationRepository;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrganizationProvider implements ProviderInterface
{
    public function __construct(
        private readonly OrganizationRepository $organizationRepository,
        private readonly TrainingSessionRepository $trainingSessionRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $organizationId = $uriVariables['organizationId'];

        $organization = $this->organizationRepository->find($organizationId);
        if (!$organization) {
            throw new NotFoundHttpException('Organization not found.');
        }

        // --- THIS IS THE FIX ---
        // Replace the old, failing findBy() call...
        // $trainingSessions = $this->trainingSessionRepository->findBy(['organization' => $organization]);

        // ...with our new custom repository method.
        $trainingSessions = $this->trainingSessionRepository->findByOrganization($organization);
        // -------------------------

        $dtoCollection = [];
        foreach ($trainingSessions as $session) {
            $dto = new OrganizationDTO();
            $dto->id = $session->getId();
            $dto->name = $session->getTraining()?->getName();

            $dto->startDate = $session->getTrainingPeriodStart();
            $dtoCollection[] = $dto;
        }

        return $dtoCollection;
    }
}
