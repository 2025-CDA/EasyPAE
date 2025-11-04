<?php

namespace App\State;

use App\Dto\InternDTO;
use App\Entity\InfoForm;
use App\Enum\InfoFormStatus;
use App\Entity\InfoFormIntern;
use App\Entity\InfoFormCompany;
use ApiPlatform\Metadata\Operation;
use App\Entity\InfoFormOrganization;
use App\Entity\InfoFormInternCompany;
use App\Repository\InfoFormRepository;
use App\Enum\InfoFormOrganizationStatus;
use App\Repository\OrganizationRepository;
use App\Repository\UserRepository;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\CompanyMemberRepository;
use App\Repository\CompanyRepository;
use App\Repository\InternMemberRepository;
use App\Repository\InfoFormInternRepository;
use JsonException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

readonly class InternProcessor implements ProcessorInterface
{
    public function __construct(
        private InfoFormRepository       $infoFormRepository,
        private InfoFormInternRepository $infoFormInternRepository,
        private InternMemberRepository   $internMemberRepository,
        private UserRepository           $userRepository,
        private EntityManagerInterface   $entityManager,
        private string                   $frontendUrl,
        private EmailService             $emailService,
        private OrganizationRepository   $organizationRepository,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): InternDTO|null
    {
        if (!$data instanceof InternDTO) {
            return null;
        }

        $operationName = $operation->getName();

        return match ($operationName) {
            'intern_infoForm_add' => $this->internInfoFormAdd($data),
            'intern_infoForm_infoFormId_infoFormIntern_edit' => $this->internInfoFormInfoFormInternEdit($data, $uriVariables),
            'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit' => $this->internInfoFormInfoFormInternInfoFormInternCompanyEdit($data, $uriVariables),
            'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation' => $this->internInfoFormInfoFormInternInfoFormInternCompanyValidation($data, $uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function internInfoFormAdd(InternDTO $data): InternDTO
    {
        $internMember = $this->internMemberRepository->find($data->internId);
        if (!$internMember) {
            throw new NotFoundHttpException('Intern member not found');
        }

        $infoForm = new InfoForm();
        $infoForm->setInternMember($internMember);

//        We should remove the hardcoded organization id if this app is going to be used for many organization (Training Center)
        $organization = $this->organizationRepository->find(1);
        $infoForm->setOrganization($organization);

// Setting the training session by checking the only active session of a user.
        $filterActiveTraining = function($ts) {
            return $ts->hasEnded() === false;
        };

        $trainingSession = $internMember->getTrainingSessions()->filter($filterActiveTraining)->first();

        if (!$trainingSession) {
            throw new NotFoundHttpException('Active training session not found for this user');
        }

        $infoForm->setTrainingSession($trainingSession);

        $infoForm->setStatus(InfoFormStatus::INITIALIZED);

        $data->internFirstName = $internMember->getUser()?->getFirstName();
        $data->internLastName = $internMember->getUser()?->getLastName();
        $data->internEmail = $internMember->getUser()?->getEmail();
        $data->trainingName = $trainingSession->getTraining()?->getName();
        $data->offerNumber = $trainingSession->getOfferNumber();
        $data->internshipStart = $trainingSession->getInternShipPeriodStart();
        $data->internshipEnd = $trainingSession->getInternShipPeriodEnd();


        $this->entityManager->persist($infoForm);

        $infoFormIntern = new InfoFormIntern();
        if ($data->infoFormInternDateStart !== null) {
            $infoFormIntern->setDateStart($data->infoFormInternDateStart);
        }
        if ($data->infoFormInternDateEnd !== null) {
            $infoFormIntern->setDateEnd($data->infoFormInternDateEnd);
        }
        if ($data->infoFormInternStatus !== null) {
            $infoFormIntern->setStatus($data->infoFormInternStatus);
        }

        $this->entityManager->persist($infoFormIntern);
        $infoForm->setInfoFormIntern($infoFormIntern);

        $infoFormOrganization = new InfoFormOrganization();
        // if ($data->infoFormOrganizationStatus !== null) {
        //     $infoFormOrganization->setStatus($data->infoFormOrganizationStatus);
        // }
        $infoFormOrganization->setStatus(InfoFormOrganizationStatus::INITIALIZED);

        $this->entityManager->persist($infoFormOrganization);
        $infoForm->setInfoFormOrganization($infoFormOrganization);


        if ($data->infoFormInternCompanyName !== null) {
            $infoFormInternCompany = new InfoFormInternCompany();
            $infoFormInternCompany->setCompanyName($data->infoFormInternCompanyName);

            if ($data->infoFormInternCompanyAddress !== null) {
                $infoFormInternCompany->setAddress($data->infoFormInternCompanyAddress);
            }

            if ($data->infoFormInternCompanyLegalRepresentativeFirstName !== null) {
                $infoFormInternCompany->setLegalRepresentativeFirstName($data->infoFormInternCompanyLegalRepresentativeFirstName);
            }

            if ($data->infoFormInternCompanyLegalRepresentativeLastName !== null) {
                $infoFormInternCompany->setLegalRepresentativeLastName($data->infoFormInternCompanyLegalRepresentativeLastName);
            }

            if ($data->infoFormInternCompanyLegalRepresentativeEmail !== null) {
                $infoFormInternCompany->setEmail($data->infoFormInternCompanyLegalRepresentativeEmail);
            }

            $this->entityManager->persist($infoFormInternCompany);
            $infoFormIntern->setInfoFormInternCompany($infoFormInternCompany);
        }

        // if ($data->infoFormCompanyStatus !== null) {
        $infoFormCompany = new InfoFormCompany();
        $infoFormCompany->setStatus($data->infoFormCompanyStatus);
        $infoForm->setInfoFormCompany($infoFormCompany);
        $this->entityManager->persist($infoFormCompany);
        // }

        $this->entityManager->flush();

        // remplir les identifiants attendus par ApiPlatform
        $data->infoFormId = $infoForm->getId();
        $data->infoFormInternId = $infoFormIntern->getId();

        return $data;
    }

    private function internInfoFormInfoFormInternEdit(InternDTO $data, array $uriVariables): InternDTO
    {
        $infoFormInternId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormInternId) {
            throw new BadRequestHttpException('Missing required URI variable: infoFormInternId');
        }

        $infoFormIntern = $this->infoFormInternRepository->find($infoFormInternId);
        if (!$infoFormIntern) {
            throw new NotFoundHttpException('InfoFormIntern not found');
        }

        if ($data->infoFormInternDateStart !== null) {
            $infoFormIntern->setDateStart($data->infoFormInternDateStart);
        }
        if ($data->infoFormInternDateEnd !== null) {
            $infoFormIntern->setDateEnd($data->infoFormInternDateEnd);
        }

        $this->entityManager->flush();

        return $data;
    }

    private function internInfoFormInfoFormInternInfoFormInternCompanyEdit(InternDTO $data, array $uriVariables): InternDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variable: infoFormId');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $infoFormIntern = $infoForm->getInfoFormIntern();
        if (!$infoFormIntern) {
            throw new NotFoundHttpException('InfoFormIntern not found for this InfoForm');
        }

        $infoFormInternCompany = $infoFormIntern->getInfoFormInternCompany();
        if (!$infoFormInternCompany) {
            $infoFormInternCompany = new InfoFormInternCompany();
            $this->entityManager->persist($infoFormInternCompany);
            $infoFormIntern->setInfoFormInternCompany($infoFormInternCompany);
        }

        if ($data->infoFormInternCompanyName !== null) {
            $infoFormInternCompany->setCompanyName($data->infoFormInternCompanyName);
        }

        if ($data->infoFormInternCompanyAddress !== null) {
            $infoFormInternCompany->setAddress($data->infoFormInternCompanyAddress);
        }

        if ($data->infoFormInternCompanyLegalRepresentativeFirstName !== null) {
            $infoFormInternCompany->setLegalRepresentativeFirstName($data->infoFormInternCompanyLegalRepresentativeFirstName);
        }

        if ($data->infoFormInternCompanyLegalRepresentativeLastName !== null) {
            $infoFormInternCompany->setLegalRepresentativeLastName($data->infoFormInternCompanyLegalRepresentativeLastName);
        }

        if ($data->infoFormInternCompanyLegalRepresentativeEmail !== null) {
            $infoFormInternCompany->setEmail($data->infoFormInternCompanyLegalRepresentativeEmail);
        }


        $this->entityManager->flush();

        return $data;
    }

    /**
     * @throws JsonException
     * @throws TransportExceptionInterface
     */
    private function internInfoFormInfoFormInternInfoFormInternCompanyValidation(InternDTO $data, array $uriVariables): InternDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variable: infoFormId');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        // 1. Mettre à jour les statuts selon le workflow
        // Changement automatique du statut InfoForm à COMPLETED_INTERN
        $infoForm->setStatus(\App\Enum\InfoFormStatus::COMPLETED_INTERN_VALIDATION);

        // Changement automatique du statut InfoFormIntern à VALIDATED
        $infoFormIntern = $infoForm->getInfoFormIntern();
        if ($infoFormIntern) {
            $infoFormIntern->setStatus(\App\Enum\InfoFormInternStatus::VALIDATED);
        }

        // 2. Changement automatique : passer le statut company à PENDING
        $infoFormCompany = $infoForm->getInfoFormCompany();
        if ($infoFormCompany) {
            $infoFormCompany->setStatus(\App\Enum\InfoFormCompanyStatus::PENDING);
        }

        $infoFormInternCompany = $infoFormIntern?->getInfoFormInternCompany();
        $companyEmail = $infoFormInternCompany?->getEmail();
        $companyName = $infoFormInternCompany?->getCompanyName();

        if (!$companyEmail) {
            throw new BadRequestHttpException('Company email is required');
        }

        // 3. Vérification de l'email du contact entreprise selon la logique du workflow
        $existingUser = $this->userRepository->findOneBy(['email' => $companyEmail]);

        if ($existingUser) {
            // CAS A - Email existe déjà : l'entreprise a déjà un compte
            $companyMember = $existingUser->getCompanyMember();

            if ($companyMember) {
                // Lier le CompanyMember existant à ce dossier
                $companyMember->addInfoForm($infoForm);
                $this->entityManager->flush();

                // Email de NOTIFICATION simple à l'entreprise existante
                // Utiliser des valeurs par défaut si firstName/lastName sont null
                $this->emailService->sendCompanyNotificationExistingUserEmail(
                    $existingUser->getEmail(),
                    $existingUser->getFirstName() ?? 'Utilisateur',
                    $existingUser->getLastName() ?? '',
                    $companyMember->getCompany()?->getName() ?? $companyName,
                    $infoForm->getInternMember()?->getUser()?->getFirstName() ?? '',
                    $infoForm->getInternMember()?->getUser()?->getLastName() ?? '',
                    $this->frontendUrl . '/login'
                );
            }

        } else {
            // CAS B - Email n'existe pas : envoyer un email au contact pour qu'il remplisse le formulaire entreprise
            // Le contact devra renseigner le SIRET dans le formulaire InfoFormCompany
            // La vérification du SIRET et la création de Company/User/CompanyMember se fera dans CompanyProcessor

            // Génération d'un lien d'activation/inscription pour le formulaire entreprise
            $registrationData = [
                'email' => $companyEmail,
                'infoFormId' => $infoFormId,
                'expires' => time() + 86400  // 24h
            ];
            $token = base64_encode(json_encode($registrationData, JSON_THROW_ON_ERROR));
            $activationLink = $this->frontendUrl . '/company/register/' . $token;

            // Email invitant le contact à compléter le formulaire entreprise (avec SIRET)
            $this->emailService->sendCompanyActivationNewCompanyEmail(
                $companyEmail,
                $infoFormInternCompany->getLegalRepresentativeFirstName() ?? '',
                $infoFormInternCompany->getLegalRepresentativeLastName() ?? '',
                $companyName ?? 'Votre entreprise',
                $infoForm->getInternMember()?->getUser()?->getFirstName() ?? '',
                $infoForm->getInternMember()?->getUser()?->getLastName() ?? '',
                $activationLink
            );
        }

        // 4. Email à l'organisme : le stagiaire a validé son volet
        // Récupérer les OrganizationMembers via la TrainingSession (table tampon organization_member_training_session)
        $trainingSession = $infoForm->getTrainingSession();
        if ($trainingSession) {
            $organizationMembers = $trainingSession->getOrganizationMembers();
            foreach ($organizationMembers as $orgMember) {
                $this->emailService->sendOrganizationInternValidatedEmail(
                    $orgMember->getUser()->getEmail(),
                    $infoForm->getInternMember()?->getUser()?->getFirstName() ?? '',
                    $infoForm->getInternMember()?->getUser()?->getLastName() ?? '',
                    $infoFormInternCompany->getCompanyName()
                );
            }
        }

        $this->entityManager->flush();

        return $data;
    }
}
