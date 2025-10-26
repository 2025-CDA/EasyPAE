<?php

namespace App\State;

use App\Dto\OrganizationDTO;
use App\Repository\OrganizationMemberRepository;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class OrganizationProvider implements ProviderInterface
{
    public function __construct(
        private TrainingSessionRepository    $trainingSessionRepository,
        private OrganizationMemberRepository $organizationMemberRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'organization_sessions' => $this->getOrganizationSessions($uriVariables),
            'organization_organizationMemberId_sessions' => $this->getOrganizationOrganizationMemberIdSessions($uriVariables),
            'organization_session_sessionId_interns' => $this->getOrganizationSessionSessionIdInterns($uriVariables),
            'organization_session_sessionId' => $this->getOrganizationSessionSessionId($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };

    }

    private function getOrganizationSessions(array $uriVariables): array
    {
        $trainingSessions = $this->trainingSessionRepository->findAll();

        $organizationDTO = [];

        foreach ($trainingSessions as $trainingSession) {
            $dto = new OrganizationDTO(); //
            $dto->sessionId = $trainingSession->getId();
            $dto->trainingName = $trainingSession->getTraining()?->getName();
            $dto->offerNumber = $trainingSession->getOfferNumber();

            $organizationMembers = $trainingSession->getOrganizationMembers();

            if (!$organizationMembers->isEmpty()) {
                $firstMember = $organizationMembers->first();
                $dto->trainerId = $firstMember->getId();
                if ($user = $firstMember?->getUser()) {
                    $dto->trainerFirstName = $user->getFirstName();
                    $dto->trainerLastName = $user->getLastName();

                }
            }

            $dto->internshipStart = $trainingSession->getInternShipPeriodStart();
            $dto->internshipEnd = $trainingSession->getInternshipPeriodEnd();

//            TODO: add percentage, I'm not sure what I'm supposed to do here.
//            $dto->validationPercentage = $trainingSession->getValidationPercentage();

            $organizationDTO[] = $dto;
        }

        return $organizationDTO;
    }


    private function getOrganizationOrganizationMemberIdSessions(array $uriVariables): array
    {
        $organizationMemberId = $uriVariables['organizationMemberId'] ?? null;

        $organizationMember = $this->organizationMemberRepository->find($organizationMemberId);

        if (!$organizationMember) {
            throw new NotFoundHttpException('Organization member not found.');
        }

        $trainingSessions = $organizationMember->getTrainingSessions();

        $dtoCollection = [];
        foreach ($trainingSessions as $trainingSession) {
            $dto = new OrganizationDTO();
            $dto->sessionId = $trainingSession->getId();

            $dto->organizationMemberId = $organizationMemberId;

            $dto->trainingName = $trainingSession->getTraining()?->getName();
            $dto->offerNumber = $trainingSession->getOfferNumber();
            $dto->internshipStart = $trainingSession->getInternShipPeriodStart();
            $dto->internshipEnd = $trainingSession->getInternshipPeriodEnd();

            $members = $trainingSession->getOrganizationMembers();
            if (!$members->isEmpty()) {
                $firstMember = $members->first();
                $dto->trainerId = $firstMember->getId();
                if ($user = $firstMember?->getUser()) {
                    $dto->trainerFirstName = $user->getFirstName();
                    $dto->trainerLastName = $user->getLastName();
                }
            }

            // TODO: Add percentage logic here as well.
            // $dto->validationPercentage = ...

            $dtoCollection[] = $dto;
        }

        return $dtoCollection;
    }

    private function getOrganizationSessionSessionIdInterns(array $uriVariables): array
    {
        $sessionId = $uriVariables['sessionId']?? null;

        $session = $this->trainingSessionRepository->find($sessionId);

        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        $dtoCollection = [];

        foreach ($session->getInfoForms() as $infoForm) {
            $internMember = $infoForm->getInternMember();

            if (!$internMember) {
                continue;
            }

            $dto = new OrganizationDTO();

            $dto->sessionId = $session->getId();
            $dto->trainingName = $session->getTraining()?->getName();

            if ($user = $internMember->getUser()) {
                $dto->internId = $user->getId();
                $dto->internFirstName = $user->getFirstName();
                $dto->internLastName = $user->getLastName();
                $dto->internLogin = $user->getLogin();
            }

            $dto->infoFormStatus = $infoForm->getStatus();

            $dtoCollection[] = $dto;
        }

        return $dtoCollection;
    }

    private function getOrganizationSessionSessionId(array $uriVariables): OrganizationDTO
    {
        $sessionId = $uriVariables['sessionId'] ?? null;

        $session = $this->trainingSessionRepository->find($sessionId);

        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        $dto = new OrganizationDTO();

        $dto->sessionId = $session->getId();
        $dto->trainingName = $session->getTraining()?->getName();
        $dto->offerNumber = $session->getOfferNumber();
        $dto->internshipStart = $session->getInternShipPeriodStart();
        $dto->internshipEnd = $session->getInternshipPeriodEnd();

        $organizationMembers = $session->getOrganizationMembers();
        if (!$organizationMembers->isEmpty()) {
            $firstMember = $organizationMembers->first();
            $dto->trainerId = $firstMember->getId();
        }

        return $dto;
    }

}
