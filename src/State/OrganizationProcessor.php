<?php

namespace App\State;

use App\Entity\User;
use App\Enum\UserRole;
use App\Entity\Training;
use Random\RandomException;
use App\Dto\OrganizationDTO;
use App\Entity\InternMember;
use App\Entity\TrainingSession;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\Operation;
use App\Service\NotificationService;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\CompanyMemberRepository;
use App\Repository\InternMemberRepository;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\Mailer\MailerInterface;
use App\Repository\OrganizationMemberRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
        private string $frontendUrl,
        private \App\Service\EmailService $emailService,
        private NotificationService $notificationService,
        private CompanyMemberRepository $companyMemberRepository
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws RandomException
     */
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
            'organization_infoForm_infoFormId_sign' => $this->organizationInfoFormSign($data, $uriVariables),
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
        $session->setTrainingPeriodStart($data->trainingPeriodStart);
        $session->setTrainingPeriodEnd($data->trainingPeriodEnd);

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        // expose l'ID de session créé afin que la plate-forme API puisse générer un IRI pour le DTO renvoyé
        // 
        $data->sessionId = $session->getId();

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
        // Ne pas définir de mot de passe pour le moment (sera défini lors de l'activation)
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

        // Générer un lien d'activation avec JWT
        $activationData = [
            'userId' => $user->getId(),
            'email' => $user->getEmail(),
            'expires' => time() + 86400  // 24h
        ];
        $token = base64_encode(json_encode($activationData, JSON_THROW_ON_ERROR));
        $activationLink = $this->frontendUrl . '/activate-account/' . $token;

        // Envoyer email d'activation au stagiaire via EmailService
        $this->emailService->sendInternAccountActivationEmail(
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName(),
            $activationLink,
            $session->getTraining()?->getName() ?? ''
        );

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

    /**
     * Signature du PAE par l'organisme
     * @throws TransportExceptionInterface
     */
    private function organizationInfoFormSign(OrganizationDTO $data, array $uriVariables): OrganizationDTO|null
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variable: infoFormId');
        }

        $infoForm = $this->entityManager->getRepository(\App\Entity\InfoForm::class)->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $infoFormOrganization = $infoForm->getInfoFormOrganization();
        if (!$infoFormOrganization) {
            throw new NotFoundHttpException('InfoFormOrganization not found');
        }

        // Mettre à jour la signature et la date de validation
        if ($data->signature !== null) {
            $infoFormOrganization->setSignature($data->signature);
        }
        
        if ($data->validationDate !== null) {
            $infoFormOrganization->setValidationDate(\DateTimeImmutable::createFromInterface($data->validationDate));
        } else {
            $infoFormOrganization->setValidationDate(new \DateTimeImmutable());
        }

        // Changements automatiques de statuts
        $infoFormOrganization->setStatus(\App\Enum\InfoFormOrganizationStatus::VALIDATED);
        $infoForm->setStatus(\App\Enum\InfoFormStatus::FULLY_COMPLETED);

        $this->entityManager->flush();


        // Envoyer emails au stagiaire et à l'entreprise via EmailService
        // envoyer notifications (stockées en base) au stagiaire si présent
        $intern = $infoForm->getInternMember()?->getUser();
        $infoFormIntern = $infoForm->getInfoFormIntern();
        $companyMembers = $infoForm->getCompanyMembers();
                if ($intern) {
            $this->notificationService->sendInfoFormValidatedInternNotification($intern, $infoForm, $infoFormIntern);
        }

        // Email au stagiaire
        if ($intern && $infoFormIntern) {
            $this->emailService->sendInternPAECompletedEmail(
                $intern->getEmail(),
                $intern->getFirstName() ?? 'Stagiaire',
                $intern->getLastName() ?? '',
                $infoFormIntern->getDateStart(),
                $infoFormIntern->getDateEnd()
            );
        }

        // Email à l'entreprise (à tous les membres de l'entreprise liés à cette InfoForm)
        if ($companyMembers && $infoFormIntern && $intern) {
            foreach ($companyMembers as $companyMember) {
                $companyUser = $companyMember->getUser();
                if ($companyUser) {
                    $this->emailService->sendCompanyPAECompletedEmail(
                        $companyUser->getEmail(),
                        $companyUser->getFirstName() ?? 'Utilisateur',
                        $companyUser->getLastName() ?? '',
                        $intern->getFirstName(),
                        $intern->getLastName(),
                        $infoFormIntern->getDateStart(),
                        $infoFormIntern->getDateEnd()
                    );
                }
            }
        }

        $dto = new OrganizationDTO();
        $dto->infoFormId = $infoFormId;

        return $dto;
    }
}
