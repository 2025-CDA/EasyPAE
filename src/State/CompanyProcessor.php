<?php

namespace App\State;

use App\Dto\CompanyDTO;
use App\Entity\TrainingSession;
use ApiPlatform\Metadata\Operation;
use App\Service\NotificationService;
use App\Repository\InfoFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\InfoFormCompanyRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class CompanyProcessor implements ProcessorInterface
{
    public function __construct(
        private InfoFormRepository $infoFormRepository,
        private InfoFormCompanyRepository $infoFormCompanyRepository,
        private EntityManagerInterface $entityManager,
        private \App\Service\EmailService $emailService,
        private NotificationService $notificationService,

    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): TrainingSession|CompanyDTO|null
    {
        if (!$data instanceof CompanyDTO) {
            return null;
        }

        $operationName = $operation->getName();

        return match ($operationName) {
            'company_infoForm_infoFormId_infoFormCompany_edit' => $this->companyInfoFormInfoFormCompanyEdit($data, $uriVariables),
            'company_infoForm_infoFormId_infoFormCompany_validation' => $this->companyInfoFormInfoFormCompanyValidation($data, $uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function companyInfoFormInfoFormCompanyEdit(CompanyDTO $data, array $uriVariables): CompanyDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variables');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        $infoFormCompanyId = $infoForm->getInfoFormCompany()?->getId();

        $infoFormCompany = $this->infoFormCompanyRepository->find($infoFormCompanyId);
        if (!$infoFormCompany) {
            throw new NotFoundHttpException('InfoFormCompany not found');
        }

        if ($infoForm->getInfoFormCompany()?->getId() !== $infoFormCompany->getId()) {
            throw new BadRequestHttpException('InfoFormCompany does not belong to this InfoForm');
        }

        // EDIT route: save only InfoFormCompany data (no Company/User creation)
        // Company data (name, address, siret, phoneNumber) will be handled in VALIDATION route

        if ($data->activity !== null) {
            $infoFormCompany->setActivity($data->activity);
        }
        if ($data->fax !== null) {
            $infoFormCompany->setFax($data->fax);
        }
        if ($data->legalRepresentativeFirstName !== null) {
            $infoFormCompany->setLegalRepresentativeFirstName($data->legalRepresentativeFirstName);
        }
        if ($data->legalRepresentativeLastName !== null) {
            $infoFormCompany->setLegalRepresentativeLastName($data->legalRepresentativeLastName);
        }
        if ($data->legalRepresentativeEmail !== null) {
            $infoFormCompany->setLegalRepresentativeEmail($data->legalRepresentativeEmail);
        }
        if ($data->tutorFirstName !== null) {
            $infoFormCompany->setTutorFirstName($data->tutorFirstName);
        }
        if ($data->tutorLastName !== null) {
            $infoFormCompany->setTutorLastName($data->tutorLastName);
        }
        if ($data->tutorEmail !== null) {
            $infoFormCompany->setTutorEmail($data->tutorEmail);
        }
        if ($data->tutorPhoneNumber !== null) {
            $infoFormCompany->setTutorPhoneNumber($data->tutorPhoneNumber);
        }

        $this->entityManager->flush();

        return $data;
    }

    private function companyInfoFormInfoFormCompanyValidation(CompanyDTO $data, array $uriVariables): CompanyDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variables');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $infoFormCompany = $infoForm->getInfoFormCompany();
        if (!$infoFormCompany) {
            throw new NotFoundHttpException('InfoFormCompany not found');
        }

        // Récupérer les données de l'email et du SIRET
        $companyEmail = $data->legalRepresentativeEmail ?? $infoForm->getInfoFormIntern()?->getInfoFormInternCompany()?->getEmail();
        $companySiret = $data->siret;

        if (!$companySiret) {
            throw new BadRequestHttpException('Company SIRET is required for validation');
        }

        // Vérifier si une Company avec ce SIRET existe déjà
        $existingCompany = $this->entityManager->getRepository(\App\Entity\Company::class)->findOneBy(['siret' => $companySiret]);

        if ($existingCompany) {
            // CAS B1 - SIRET existe : rattacher le User à la Company existante
            $existingUser = $this->entityManager->getRepository(\App\Entity\User::class)->findOneBy(['email' => $companyEmail]);

            if ($existingUser) {
                // CAS A : User existe déjà - vérifier s'il a déjà un CompanyMember
                $existingCompanyMember = $existingUser->getCompanyMember();

                if ($existingCompanyMember) {
                    // CAS A : CompanyMember existe - simplement lier à ce dossier
                    $existingCompanyMember->addInfoForm($infoForm);
                } else {
                    // User existe mais pas de CompanyMember - créer le CompanyMember
                    $newCompanyMember = new \App\Entity\CompanyMember();
                    $newCompanyMember->setUser($existingUser);
                    $newCompanyMember->setCompany($existingCompany);
                    $newCompanyMember->setRole(\App\Enum\CompanyRole::LEGAL_REPRESENTATIVE);
                    $newCompanyMember->addInfoForm($infoForm);
                    $this->entityManager->persist($newCompanyMember);
                }
            } else {
                // CAS B1 : User n'existe pas - créer User + CompanyMember
                $newUser = new \App\Entity\User();
                $newUser->setEmail($companyEmail);
                $newUser->setFirstName($data->legalRepresentativeFirstName);
                $newUser->setLastName($data->legalRepresentativeLastName);
                $newUser->setRole(\App\Enum\UserRole::COMPANY);
                // Mot de passe vide au départ - l'utilisateur le définira via le lien d'activation
                $newUser->setPassword('');
                $this->entityManager->persist($newUser);

                // Créer le CompanyMember et le rattacher à la Company existante
                $newCompanyMember = new \App\Entity\CompanyMember();
                $newCompanyMember->setUser($newUser);
                $newCompanyMember->setCompany($existingCompany);
                $newCompanyMember->setRole(\App\Enum\CompanyRole::LEGAL_REPRESENTATIVE);
                $newCompanyMember->addInfoForm($infoForm);
                $this->entityManager->persist($newCompanyMember);
            }
        } else {
            // CAS B2 - SIRET n'existe pas : créer une nouvelle Company
            $newCompany = new \App\Entity\Company();
            $newCompany->setName($data->name);
            $newCompany->setAddress($data->address);
            $newCompany->setSiret($companySiret);
            $newCompany->setPhoneNumber($data->phoneNumber);
            $this->entityManager->persist($newCompany);

            $existingUser = $this->entityManager->getRepository(\App\Entity\User::class)->findOneBy(['email' => $companyEmail]);

            if ($existingUser) {
                // User existe déjà - vérifier s'il a un CompanyMember
                $existingCompanyMember = $existingUser->getCompanyMember();

                if ($existingCompanyMember) {
                    // CompanyMember existe - le rattacher à la nouvelle Company et à ce dossier
                    $existingCompanyMember->setCompany($newCompany);
                    $existingCompanyMember->addInfoForm($infoForm);
                } else {
                    // User existe mais pas de CompanyMember - créer le CompanyMember
                    $newCompanyMember = new \App\Entity\CompanyMember();
                    $newCompanyMember->setUser($existingUser);
                    $newCompanyMember->setCompany($newCompany);
                    $newCompanyMember->setRole(\App\Enum\CompanyRole::LEGAL_REPRESENTATIVE);
                    $newCompanyMember->addInfoForm($infoForm);
                    $this->entityManager->persist($newCompanyMember);
                }
            } else {
                // CAS B2 : User n'existe pas - créer User + CompanyMember + nouvelle Company
                $newUser = new \App\Entity\User();
                $newUser->setEmail($companyEmail);
                $newUser->setFirstName($data->legalRepresentativeFirstName);
                $newUser->setLastName($data->legalRepresentativeLastName);
                $newUser->setRole(\App\Enum\UserRole::COMPANY);
                // Mot de passe vide au départ - l'utilisateur le définira via le lien d'activation
                $newUser->setPassword('');
                $this->entityManager->persist($newUser);

                // Créer le CompanyMember et le rattacher à la nouvelle Company
                $newCompanyMember = new \App\Entity\CompanyMember();
                $newCompanyMember->setUser($newUser);
                $newCompanyMember->setCompany($newCompany);
                $newCompanyMember->setRole(\App\Enum\CompanyRole::LEGAL_REPRESENTATIVE);
                $newCompanyMember->addInfoForm($infoForm);
                $this->entityManager->persist($newCompanyMember);
            }
        }

        // Mettre à jour InfoFormCompany avec toutes les données du formulaire
        if ($data->activity !== null) {
            $infoFormCompany->setActivity($data->activity);
        }
        if ($data->fax !== null) {
            $infoFormCompany->setFax($data->fax);
        }
        if ($data->legalRepresentativeFirstName !== null) {
            $infoFormCompany->setLegalRepresentativeFirstName($data->legalRepresentativeFirstName);
        }
        if ($data->legalRepresentativeLastName !== null) {
            $infoFormCompany->setLegalRepresentativeLastName($data->legalRepresentativeLastName);
        }
        if ($data->legalRepresentativeEmail !== null) {
            $infoFormCompany->setLegalRepresentativeEmail($data->legalRepresentativeEmail);
        }
        if ($data->tutorFirstName !== null) {
            $infoFormCompany->setTutorFirstName($data->tutorFirstName);
        }
        if ($data->tutorLastName !== null) {
            $infoFormCompany->setTutorLastName($data->tutorLastName);
        }
        if ($data->tutorEmail !== null) {
            $infoFormCompany->setTutorEmail($data->tutorEmail);
        }
        if ($data->tutorPhoneNumber !== null) {
            $infoFormCompany->setTutorPhoneNumber($data->tutorPhoneNumber);
        }

        // Changement automatique du statut InfoForm à COMPLETED_COMPANY
        $infoForm->setStatus(\App\Enum\InfoFormStatus::COMPLETED_COMPANY_VALIDATION);

        if ($data->infoFormCompanyStatus !== null) {
            $infoFormCompany->setStatus($data->infoFormCompanyStatus);
        }

        // Changement automatique : passer le statut organization à PENDING
        $infoForm->getInfoFormOrganization()?->setStatus(\App\Enum\InfoFormOrganizationStatus::PENDING);

        $this->entityManager->flush();

        // Envoyer emails au stagiaire et à l'organisme
        $intern = $infoForm->getInternMember()?->getUser();
        $infoFormIntern = $infoForm->getInfoFormIntern();
        $companyName = $data->name ?? $infoForm->getInfoFormIntern()?->getInfoFormInternCompany()?->getCompanyName();

        // Email au stagiaire
        if ($intern && $infoFormIntern) {
            $this->emailService->sendInternCompanyValidatedEmail(
                $intern->getEmail(),
                $intern->getFirstName(),
                $intern->getLastName(),
                $companyName,
                $infoFormIntern->getDateStart(),
                $infoFormIntern->getDateEnd()
            );
        }

        // Email à l'organisme
        // Récupérer les OrganizationMembers via la TrainingSession (table tampon organization_member_training_session)
        $trainingSession = $infoForm->getTrainingSession();
        if ($trainingSession) {
            $organizationMembers = $trainingSession->getOrganizationMembers();
            foreach ($organizationMembers as $orgMember) {
                $this->emailService->sendOrganizationCompanyValidatedEmail(
                    $orgMember->getUser()->getEmail(),
                    $intern?->getFirstName() ?? '',
                    $intern?->getLastName() ?? '',
                    $companyName
                );
            }
        }

        //Notification dans easyPAE
        $organization = $infoForm->getOrganization()->getOrganizationMembers()->first()->getUser();

        if ($intern) {
            $this->notificationService->sendToInternWhenInfoFormCompanyDoneNotification($intern, $infoFormIntern, $infoForm);
        }
        if ($organization) {
            $this->notificationService->sendToOrganizationWhenInfoFormCompanyDoneNotification($organization, $infoFormIntern, $infoForm);
        }

        return $data;
    }
}
