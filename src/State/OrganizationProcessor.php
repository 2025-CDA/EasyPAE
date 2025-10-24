<?php

namespace App\State;

use App\Dto\OrganizationDTO;
use App\Entity\InfoForm;
use App\Entity\InternMember;
use App\Entity\Training;
use App\Entity\TrainingSession;
use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use App\Enum\UserRole;
use App\Repository\InternMemberRepository;
use App\Repository\OrganizationMemberRepository;
use App\Repository\TrainingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class OrganizationProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface       $entityManager,
        private OrganizationMemberRepository $organizationMemberRepository,
        private TrainingRepository           $trainingRepository,
        private TrainingSessionRepository    $trainingSessionRepository,
        private UserRepository               $userRepository,
        private InternMemberRepository       $internMemberRepository,
        private UserPasswordHasherInterface  $passwordHasher,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): TrainingSession|OrganizationDTO|null
    {
        if (!$data instanceof OrganizationDTO) {
            return null;
        }

        $operationName = $operation->getName();

        return match ($operationName) {
            'organization_session_add' => $this->organizationSessionAdd($data),
            'organization_session_sessionId_intern_add' => $this->organizationSessionSessionIdInternAdd($data, $uriVariables),
            'organization_session_sessionId_edit' => $this->organizationSessionSessionIdEdit($data, $uriVariables),
            'organization_session_sessionId_archive' => $this->organizationSessionSessionIdArchive($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function organizationSessionAdd(OrganizationDTO $dto): TrainingSession
    {
        if ($dto->trainerId === null || empty(trim($dto->trainingName ?? ''))) {
            throw new BadRequestHttpException('Trainer ID and a non-empty Training Name are required.');
        }

        $trainer = $this->organizationMemberRepository->find($dto->trainerId);
        if (!$trainer) {
            throw new NotFoundHttpException('Trainer not found.');
        }

        $training = $this->trainingRepository->findOneBy(['name' => $dto->trainingName]);
        if (!$training) {
            $training = new Training();
            $training->setName($dto->trainingName);
            $this->entityManager->persist($training);
        }

        $session = new TrainingSession();
        $session->setTraining($training);
        $session->setOfferNumber($dto->offerNumber);
        $session->setInternShipPeriodStart($dto->internshipStart);
        $session->setInternshipPeriodEnd($dto->internshipEnd);

        $session->addOrganizationMember($trainer);

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }

    private function organizationSessionSessionIdInternAdd(OrganizationDTO $dto, array $uriVariables): TrainingSession
    {
        $sessionId = $uriVariables['sessionId'];
        $session = $this->trainingSessionRepository->find($sessionId);
        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        if (empty($dto->internEmail)) {
            throw new BadRequestHttpException('Intern email is required to add an intern.');
        }

        $user = $this->userRepository->findOneBy(['email' => $dto->internEmail]);
        if (!$user) {
            $user = new User();
            $user->setEmail($dto->internEmail);
            $user->setFirstName($dto->internFirstName);
            $user->setLastName($dto->internLastName);
            $user->setLogin($dto->internLogin);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            $user->setRole(UserRole::INTERN);


            $this->entityManager->persist($user);
        }

        $internMember = $this->internMemberRepository->findOneBy(['user' => $user]);
        if (!$internMember) {
            $internMember = new InternMember();
            $internMember->setUser($user);
            $this->entityManager->persist($internMember);
        }

        foreach ($session->getInfoForms() as $existingInfoForm) {
            if ($existingInfoForm->getInternMember() === $internMember) {
                throw new BadRequestHttpException('This intern is already part of the session.');
            }
        }

        $infoForm = new InfoForm();
        $infoForm->setTrainingSession($session);
        $infoForm->setInternMember($internMember);
//        $infoForm->setStatus(InfoFormStatus::PENDING);

        $this->entityManager->persist($infoForm);

        $this->entityManager->flush();

        return $session;
    }

    private function organizationSessionSessionIdEdit(OrganizationDTO $dto, array $uriVariables): OrganizationDTO
    {
        $sessionId = $uriVariables['sessionId'];
        $session = $this->trainingSessionRepository->find($sessionId);
        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        if ($dto->trainingName !== null) {
            $training = $this->trainingRepository->findOneBy(['name' => $dto->trainingName]);
            if (!$training) {
                $training = new Training();
                $training->setName($dto->trainingName);
                $this->entityManager->persist($training);
            }
            $session->setTraining($training);
        }

        if ($dto->trainerId !== null) {
            $trainer = $this->organizationMemberRepository->find($dto->trainerId);
            if (!$trainer) {
                throw new NotFoundHttpException('The specified trainer with ID ' . $dto->trainerId . ' was not found.');
            }
            $session->addOrganizationMember($trainer);
        }

        if ($dto->offerNumber !== null) {
            $session->setOfferNumber($dto->offerNumber);
        }
        if ($dto->internshipStart !== null) {
            $session->setInternShipPeriodStart($dto->internshipStart);
        }
        if ($dto->internshipEnd !== null) {
            $session->setInternshipPeriodEnd($dto->internshipEnd);
        }

        $this->entityManager->flush();

        $dto->sessionId = $sessionId;

        return $dto;
    }

    private function organizationSessionSessionIdArchive(array $uriVariables): OrganizationDTO
    {
        $sessionId = $uriVariables['sessionId'];
        $session = $this->trainingSessionRepository->find($sessionId);

        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        if ($session->hasEnded()) {
            throw new BadRequestHttpException('Training session is already archived.');
        }

        $session->setHasEnded(1);
        $this->entityManager->flush();


        $organizationDTO = [];
        $dto = new OrganizationDTO();
        $dto->hasEnded = 1;
        $dto->sessionId = $sessionId;

        return $dto;
    }

}
