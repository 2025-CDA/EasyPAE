<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\OrganizationDTO;
use App\Repository\OrganizationRepository;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InternProvider implements ProviderInterface
{
    public function __construct(
        private readonly OrganizationRepository    $organizationRepository,
        private readonly TrainingSessionRepository $trainingSessionRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {

        return [];

    }
}
