<?php

namespace App\State;

use App\Dto\OrganizationDTO;
use App\Entity\InfoForm;
use App\Entity\InternMember;
use App\Entity\Organization;
use App\Entity\Training;
use App\Entity\TrainingSession;
use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use App\Enum\InfoFormStatus;
use App\Enum\UserRole;
use App\Repository\InternMemberRepository;
use App\Repository\OrganizationMemberRepository;
use App\Repository\TrainingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\OrganizationRepository;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class OrganizationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly OrganizationMemberRepository $organizationMemberRepository,
        private readonly TrainingRepository $trainingRepository,
        private readonly TrainingSessionRepository $trainingSessionRepository,
        private readonly UserRepository $userRepository,
        private readonly InternMemberRepository $internMemberRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ?TrainingSession
    {
        if (!$data instanceof OrganizationDTO) {
            return null;
        }

        $operationName = $operation->getName();

        return match ($operationName) {
            'organization_session_add' => $this->organizationSessionAdd($data),
            'organization_session_sessionId_intern_add' => $this->organizationSessionSessionIdInternAdd($data, $uriVariables),
            'organization_session_sessionId_edit' => $this->organizationSessionSessionIdEdit($data, $uriVariables, $context),
            'organization_session_sessionId_archive' => $this->organizationSessionSessionIdArchive($data, $uriVariables),
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
        // 1. Find the parent TrainingSession from the URL
        $sessionId = $uriVariables['sessionId'];
        $session = $this->trainingSessionRepository->find($sessionId);
        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        // 2. Validate that an email was provided for the intern
        if (empty($dto->internEmail)) {
            throw new BadRequestHttpException('Intern email is required to add an intern.');
        }

        // 3. Find or create the User for the intern
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

        // 4. Find or create the InternMember profile for the User
        $internMember = $this->internMemberRepository->findOneBy(['user' => $user]);
        if (!$internMember) {
            $internMember = new InternMember();
            $internMember->setUser($user);
            $this->entityManager->persist($internMember);
        }

        // 5. Check if this intern is already in the session to prevent duplicates
        foreach ($session->getInfoForms() as $existingInfoForm) {
            if ($existingInfoForm->getInternMember() === $internMember) {
                throw new BadRequestHttpException('This intern is already part of the session.');
            }
        }

        // 6. Create the InfoForm to link the intern to the session
        $infoForm = new InfoForm();
        $infoForm->setTrainingSession($session);
        $infoForm->setInternMember($internMember);
//        $infoForm->setStatus(InfoFormStatus::PENDING); // Set a default status

        $this->entityManager->persist($infoForm);

        // 7. Save everything to the database
        $this->entityManager->flush();

        // 8. Return the updated session
        return $session;
    }

    private function organizationSessionSessionIdEdit(OrganizationDTO $data, array $uriVariables, array $context)
    {
    }

    private function organizationSessionSessionIdArchive(array $uriVariables)
    {
    }

}
