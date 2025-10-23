<?php

namespace App\State;

use App\Dto\OrganizationDTO;
use App\Entity\Organization;
use App\Entity\TrainingSession;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\OrganizationRepository;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class OrganizationProcessor implements ProcessorInterface
{
    public function __construct(
        private TrainingSessionRepository $trainingSessionRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): OrganizationDTO
    {
        // Récupération de l'organisation existante à partir de l'identifiant
        $trainingSession = $this->trainingSessionRepository->find($uriVariables['id'] ?? null);
        if (!$trainingSession instanceof TrainingSession) {
            throw new \RuntimeException('Organization not found for update.');
        }

        // Application des changements provenant du DTO
        if ($data->name !== null) {
            $trainingSession->getTraining()->setName($data->name);
        }
        if ($data->startDate !== null) {
            $trainingSession->setInternShipPeriodStart($data->startDate);
        }
        if ($data->endDate !== null) {
            $trainingSession->setInternShipPeriodEnd($data->endDate);
        }
        if ($data->offerNumber !== null) {
            $trainingSession->setOfferNumber($data->offerNumber);
        }

        // Enregistrement des modifications
        $this->entityManager->persist($trainingSession);
        $this->entityManager->flush();

        // Retourne une version DTO de l'entité mise à jour
        $dto = new OrganizationDTO();
        $dto->id = $trainingSession->getId();
        $dto->name = $trainingSession-> getTraining()->getName();
        $dto->startDate = $trainingSession->getInternShipPeriodStart();
        $dto->endDate = $trainingSession->getInternShipPeriodEnd();
        $dto->offerNumber = $trainingSession->getOfferNumber();

        return $dto;
    }
}
