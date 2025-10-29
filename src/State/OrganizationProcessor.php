<?php

namespace App\State;

use App\Dto\OrganizationDTO;
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
use Random\RandomException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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
        private MailerInterface $mailer,
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

    private function organizationSessionAdd(OrganizationDTO $data): OrganizationDTO|null
    {
        if ($data->trainerId === null || empty(trim($data->trainingName ?? ''))) {
            throw new BadRequestHttpException('Trainer ID and a non-empty Training Name are required.');
        }

        $trainer = $this->organizationMemberRepository->find($data->trainerId);
        if (!$trainer) {
            throw new NotFoundHttpException('Trainer not found.');
        }

        $training = $this->trainingRepository->findOneBy(['name' => $data->trainingName]);
        if (!$training) {
            throw new NotFoundHttpException('Training not found.');
        }

        $offerNumber = $this->trainingSessionRepository->findOneBy(['offerNumber'=> $data->offerNumber]);
        if ($offerNumber) {
            throw new BadRequestHttpException('A training session with this offerNumber already exists.');
        }

        $session = new TrainingSession();
        $session->setTraining($training);
        $session->setOfferNumber($data->offerNumber);
        $session->setInternShipPeriodStart($data->internshipStart);
        $session->setInternshipPeriodEnd($data->internshipEnd);
        $session->addOrganizationMember($trainer);

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $data;
    }

    /**
     * @throws RandomException|TransportExceptionInterface
     */
    private function organizationSessionSessionIdInternAdd(OrganizationDTO $data, array $uriVariables): OrganizationDTO|null
    {
        $sessionId = $uriVariables['sessionId'] ?? null;
        $session = $this->trainingSessionRepository->find($sessionId);
        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        if (empty($data->internEmail)) {
            throw new BadRequestHttpException('Intern email is required to add an intern.');
        }

        $user = $this->userRepository->findOneBy(['email' => $data->internEmail]);
        if ($user) {
            throw new BadRequestHttpException('A user with this email already exists.');
        }

        $user = new User();
        $user->setEmail($data->internEmail);
        $user->setFirstName($data->internFirstName);
        $user->setLastName($data->internLastName);
        $user->setLogin($data->internLogin);
        $plainPassword = substr(base64_encode(random_bytes(12)), 0, 16); // 16 random chars with mixed case
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);
        $user->setRole(UserRole::INTERN);

        $this->entityManager->persist($user);

        $internMember = $this->internMemberRepository->findOneBy(['user' => $user]);
        if ($internMember) {
            throw new BadRequestHttpException('An intern member with this user already exists.');
        }

        $internMember = new InternMember();
        $internMember->setUser($user);
        $this->entityManager->persist($internMember);

        if ($session->getInternMembers()->contains($internMember)) {
            throw new BadRequestHttpException('This intern is already part of the session.');
        }

        $this->entityManager->flush();

//      This is functional but we can change it if needed.
        $email = (new TemplatedEmail())
            ->from(new Address('inscription-stagiaire@easypae.com', 'EasyPAE'))
            ->to(new Address($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName()))
            ->subject('Bienvenue sur EasyPAE - Vos identifiants de connexion')
            ->htmlTemplate('emails/intern_welcome.html.twig')
            ->context([
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'internEmail' => $user->getEmail(),
                'login' => $user->getLogin(),
                'password' => $plainPassword,
                'trainingSession' => $session->getTraining()?->getName(),
            ]);

        $this->mailer->send($email);

        $data->plainPassword = $plainPassword;
//        TODO: change this later, this is just for testing.

        return $data;
    }

    private function organizationSessionSessionIdEdit(OrganizationDTO $data, array $uriVariables): OrganizationDTO|null
    {
        $sessionId = $uriVariables['sessionId'] ?? null;
        $session = $this->trainingSessionRepository->find($sessionId);
        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        if ($data->trainingName !== null) {
            $training = $this->trainingRepository->findOneBy(['name' => $data->trainingName]);
            if ($training) {
                $session->setTraining($training);
            } else {
                throw new NotFoundHttpException('Training name not found.');
            }
        }

        if ($data->trainerId !== null) {
            $trainer = $this->organizationMemberRepository->find($data->trainerId);
            if (!$trainer) {
                throw new NotFoundHttpException('The specified trainer with ID ' . $data->trainerId . ' was not found.');
            }
            $session->addOrganizationMember($trainer);
        }

        if ($data->offerNumber !== null) {
            $session->setOfferNumber($data->offerNumber);
        }
        if ($data->internshipStart !== null) {
            $session->setInternShipPeriodStart($data->internshipStart);
        }
        if ($data->internshipEnd !== null) {
            $session->setInternshipPeriodEnd($data->internshipEnd);
        }

        $this->entityManager->flush();

        $data->sessionId = $sessionId;

        return $data;
    }

    private function organizationSessionSessionIdArchive(array $uriVariables): OrganizationDTO|null
    {
        $sessionId = $uriVariables['sessionId'] ?? null;
        $session = $this->trainingSessionRepository->find($sessionId);

        if (!$session) {
            throw new NotFoundHttpException('Training session not found.');
        }

        if ($session->hasEnded()) {
            throw new BadRequestHttpException('Training session is already archived.');
        }

        $session->setHasEnded(1);
        $this->entityManager->flush();

        $dto = new OrganizationDTO();
        $dto->hasEnded = 1;
        $dto->sessionId = $sessionId;

        return $dto;
    }
}
