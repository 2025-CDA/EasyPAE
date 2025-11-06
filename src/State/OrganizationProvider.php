<?php

namespace App\State;

use App\Dto\OrganizationDTO;
use App\Enum\InfoFormStatus;
use ApiPlatform\Metadata\Operation;
use App\Repository\TrainingRepository;
use ApiPlatform\State\ProviderInterface;
use App\Repository\TrainingSessionRepository;
use App\Repository\OrganizationMemberRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class OrganizationProvider implements ProviderInterface
{
    public function __construct(
        private TrainingSessionRepository    $trainingSessionRepository,
        private OrganizationMemberRepository $organizationMemberRepository,
        private TrainingRepository $trainingRepository,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'organization_sessions' => $this->getOrganizationSessions($uriVariables),
            'organization_organizationMemberId_sessions' => $this->getOrganizationOrganizationMemberIdSessions($uriVariables),
            'organization_session_sessionId_interns' => $this->getOrganizationSessionSessionIdInterns($uriVariables),
            'organization_session_sessionId' => $this->getOrganizationSessionSessionId($uriVariables),
            'organization_training_names' => $this->getAllTrainingNames(),
            'organization_infoForm_infoFormId_pdf' => $this->getInfoFormPdf($uriVariables),
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
            $dto->trainingId = $trainingSession->getTraining()?->getId();
            $dto->trainingName = $trainingSession->getTraining()?->getName();
            $dto->offerNumber = $trainingSession->getOfferNumber();
            $dto->category = $trainingSession->getTraining()?->getCategory();

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
            $dto->trainingPeriodStart = $trainingSession->getTrainingPeriodStart();
            $dto->trainingPeriodEnd = $trainingSession->getTrainingPeriodEnd();

            $totalFormsWithStatus = 0;
            $validatedForms = 0;

            $trainingSessions = $this->trainingSessionRepository->findAll();
            foreach ($trainingSessions as $trainingSession) {
                $infoForms = $trainingSession->getInfoForms();

                foreach ($infoForms as $infoForm) {
                    if ($infoForm->getStatus() !== null) {
                        $totalFormsWithStatus++;

                        $status = $infoForm->getStatus();
                        if ($status === InfoFormStatus::FULLY_COMPLETED) {
                            $validatedForms++;
                        }
                    }
                }
            }

            $validationPercentage = $totalFormsWithStatus > 0
                ? ($validatedForms / $totalFormsWithStatus) * 100
                : 0;
            $dto->validationPercentage = round($validationPercentage, 2);

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
        $sessionId = $uriVariables['sessionId'] ?? null;

        $session = $this->trainingSessionRepository->find($sessionId);

        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        $dtoCollection = [];

        foreach ($session->getInternMembers() as $internMember) {

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

//           TODO: change this later, we put first() only for the demo.
            $dto->infoFormStatus = $internMember->getInfoForm()?->first()?->getStatus();
            $dto->infoFormId= $internMember->getInfoForm()?->first()?->getId();

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
        $dto->category = $session->getTraining()?->getCategory();
        $dto->trainingPeriodStart = $session->getTrainingPeriodStart();
        $dto->trainingPeriodEnd = $session->getTrainingPeriodEnd();


        $organizationMembers = $session->getOrganizationMembers();
        if (!$organizationMembers->isEmpty()) {
            $firstMember = $organizationMembers->first();
            $dto->trainerId = $firstMember->getId();
        }

        return $dto;
    }

    public function getAllTrainingNames(): array
    {
        $trainings = $this->trainingRepository->findAll();
        $map = [];

        foreach ($trainings as $training) {
            if (!is_object($training) || !method_exists($training, 'getId') || !method_exists($training, 'getName')) {
            }

            $id = $training->getId();
            $name = $training->getName();
            $map[$id] = $name;
        }

        $result = [];
        foreach ($map as $id => $name) {
            $result[] = ['id' => $id, 'name' => $name];
        }
        return $result;
    }

    private function getInfoFormPdf(array $uriVariables)
    {
    }
}
