<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\InfoFormDTO;

use App\Repository\InfoFormRepository;
use App\Repository\InfoFormCompanyRepository;
use App\Repository\InfoFormInternRepository;
use App\Repository\InfoFormOrganizationRepository;
use App\Repository\InternMemberRepository;
use App\Repository\TrainingSessionRepository;
use App\Enum\InfoFormStatus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InfoFormProvider implements ProviderInterface
{
    public function __construct(
        private readonly InfoFormRepository $infoFormRepository,
        private readonly InfoFormCompanyRepository $infoFormCompanyRepository,
        private readonly InfoFormInternRepository $infoFormInternRepository,
        private readonly InfoFormOrganizationRepository $infoFormOrganizationRepository,
        private readonly InternMemberRepository $internMemberRepository,
        private readonly TrainingSessionRepository $trainingSessionRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'intern_resume_card' => $this->getInternResumeCard($uriVariables),
            'organization_resume_card' => $this->getOrganizationResumeCard($uriVariables),
            'company_resume_card' => $this->getCompanyResumeCard($uriVariables),
            'full_resume_form' => $this->getFullResumeForm($uriVariables),
            'info_form_status' => $this->getInfoFormStatus($uriVariables),
            'info_form_company_status' => $this->getInfoFormCompanyStatus($uriVariables),
            'info_form_intern_status' => $this->getInfoFormInternStatus($uriVariables),
            'info_form_organization_status' => $this->getInfoFormOrganizationStatus($uriVariables),
            'internship_dates' => $this->getInternshipDates($uriVariables),
            'training_dates' => $this->getTrainingDates($uriVariables),
            'percentage_form_validation' => $this->getPercentageFormValidation($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function getInternResumeCard(array $uriVariables): InfoFormDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        if (!$infoFormId) {
            throw new BadRequestHttpException('InfoForm ID is required');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $internMember = $infoForm->getInternMember();
        if (!$internMember) {
            throw new NotFoundHttpException('InternMember not found for this InfoForm');
        }

        $user = $internMember->getUser();
        $trainingSession = $infoForm->getTrainingSession();
        $organization = $infoForm->getOrganization();

        // Récupérer l'utilisateur de l'organisation assigné à cette session
        $organizationUser = null;
        if ($organization && $organization->getOrganizationMembers()->count() > 0) {
            // ALTERNATIVES possibles :
            // 1. Trouver le membre avec un rôle spécifique (formateur, référent, etc.)
            // 2. Utiliser une relation directe InfoForm -> OrganizationMember
            // 3. Créer un champ "responsable" dans InfoForm

            // Pour l'instant : prendre le premier membre
            $firstOrganizationMember = $organization->getOrganizationMembers()->first();
            if ($firstOrganizationMember) {
                $organizationUser = $firstOrganizationMember->getUser();
            }
        }

        $dto = new InfoFormDTO();
        $dto->id = 'resume_card_' . $infoFormId;
        $dto->internAvatar = $user->getAvatar();
        $dto->internFirstName = $user->getFirstName();
        $dto->internLastName = $user->getLastName();
        $dto->internLogin = $user->getLogin();
        $dto->internEmail = $user->getEmail();
        $dto->trainingTitle = $trainingSession?->getTraining()?->getName();
        $dto->offerNumber = $trainingSession?->getOfferNumber();
        $dto->organizationUserFirstName = $organizationUser?->getFirstName();
        $dto->organizationUserLastName = $organizationUser?->getLastName();
        $dto->internshipStartDate = $trainingSession?->getInternShipPeriodStart();
        $dto->internshipEndDate = $trainingSession?->getInternshipPeriodEnd();

        return $dto;
    }

    private function getOrganizationResumeCard(array $uriVariables): InfoFormDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        if (!$infoFormId) {
            throw new BadRequestHttpException('InfoForm ID is required');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $organization = $infoForm->getOrganization();
        if (!$organization) {
            throw new NotFoundHttpException('Organization not found for this InfoForm');
        }

        // Récupérer l'utilisateur de l'organisation assigné à cette session
        $organizationUser = null;
        if ($organization->getOrganizationMembers()->count() > 0) {
            // Prendre le premier membre de l'organisation pour simplifier
            $firstOrganizationMember = $organization->getOrganizationMembers()->first();
            if ($firstOrganizationMember) {
                $organizationUser = $firstOrganizationMember->getUser();
            }
        }

        $dto = new InfoFormDTO();
        $dto->id = 'organization_resume_card_' . $infoFormId;
        $dto->organizationUserAvatar = $organizationUser?->getAvatar();
        $dto->organizationName = $organization->getName();

        return $dto;
    }

    private function getCompanyResumeCard(array $uriVariables): InfoFormDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        if (!$infoFormId) {
            throw new BadRequestHttpException('InfoForm ID is required');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $company = $infoForm->getCompany();
        if (!$company) {
            throw new NotFoundHttpException('Company not found for this InfoForm');
        }

        // Récupérer l'utilisateur de l'entreprise (tuteur)
        $companyUser = null;
        $tutorName = null;
        if ($company->getCompanyMembers()->count() > 0) {
            // ALTERNATIVES possibles :
            // 1. Filtrer par rôle : $company->getCompanyMembers()->filter(fn($m) => $m->getRole() === 'TUTEUR')
            // 2. Utiliser les données InfoFormCompany (tutor_first_name, tutor_last_name)
            // 3. Créer une relation directe InfoForm -> CompanyMember (tuteur)

            // Pour l'instant : prendre le premier membre
            $firstCompanyMember = $company->getCompanyMembers()->first();
            if ($firstCompanyMember) {
                $companyUser = $firstCompanyMember->getUser();
                $tutorName = $companyUser->getFirstName() . ' ' . $companyUser->getLastName();
            }
        }

        $dto = new InfoFormDTO();
        $dto->id = 'company_resume_card_' . $infoFormId;
        $dto->companyUserAvatar = $companyUser?->getAvatar();
        $dto->companyName = $company->getName();
        $dto->companyAddress = null;
        // TODO: Ajouter la propriété address à l'entité Company
        // Arnaud: C'est fait
        $dto->companyContactEmail = $companyUser?->getEmail(); // Utiliser l'email de l'utilisateur de l'entreprise
        $dto->companyPhoneNumber = $company->getPhoneNumber();
        $dto->tutorName = $tutorName;

        return $dto;
    }

    private function getFullResumeForm(array $uriVariables): InfoFormDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        if (!$infoFormId) {
            throw new BadRequestHttpException('InfoForm ID is required');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $dto = new InfoFormDTO();
        $dto->id = 'full_resume_form_' . $infoFormId;

        $internMember = $infoForm->getInternMember();
        $trainingSession = $infoForm->getTrainingSession();
        $company = $infoForm->getCompany();

        if ($internMember && $internMember->getUser()) {
            $user = $internMember->getUser();
            $dto->internFirstNameFull = $user->getFirstName();
            $dto->internLastNameFull = $user->getLastName();
            $dto->internEmailFull = $user->getEmail();
        }

        if ($trainingSession) {
            $dto->trainingNameFull = $trainingSession->getTraining()?->getName();
            $dto->trainingOfferNumberFull = $trainingSession->getOfferNumber();
            $dto->internshipStartDateFull = $trainingSession->getInternshipPeriodStart();
            $dto->internshipEndDateFull = $trainingSession->getInternshipPeriodEnd();
        }

        if ($company) {
            $dto->companyNameFull = $company->getName();
            $dto->companyPhoneNumberFull = $company->getPhoneNumber();
            $dto->companySiretFull = $company->getSiret();

            $tutorMember = null;
            $legalRepMember = null;

            foreach ($company->getCompanyMembers() as $member) {
                if ($member->getRole() === 'Tuteur' && !$tutorMember) {
                    $tutorMember = $member;
                } elseif ($member->getRole() === 'Représentant légal' && !$legalRepMember) {
                    $legalRepMember = $member;
                }
            }

            if ($tutorMember && $tutorMember->getUser()) {
                $tutorUser = $tutorMember->getUser();
                $dto->tutorFirstNameFull = $tutorUser->getFirstName();
                $dto->tutorLastNameFull = $tutorUser->getLastName();
                $dto->tutorEmailFull = $tutorUser->getEmail();
            }

            if ($legalRepMember && $legalRepMember->getUser()) {
                $legalRepUser = $legalRepMember->getUser();
                $dto->legalResponsibleFirstNameFull = $legalRepUser->getFirstName();
                $dto->legalResponsibleLastNameFull = $legalRepUser->getLastName();
                $dto->legalResponsibleEmailFull = $legalRepUser->getEmail();
            }

            // Utiliser les infos générales de l'entreprise
            $dto->companyNameFull = $company->getName();
            $dto->companyContactEmailFull = $tutorMember?->getUser()?->getEmail();
            $dto->companyEmailFull = $tutorMember?->getUser()?->getEmail();
        }

        return $dto;
    }

    private function getInfoFormStatus(array $uriVariables): InfoFormDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        if (!$infoFormId) {
            throw new BadRequestHttpException('InfoForm ID is required');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $dto = new InfoFormDTO();
        $dto->id = 'info_form_status_' . $infoFormId;

        $status = $infoForm->getStatus();
        $dto->infoFormStatus = $status?->value ?? 'unknown';

        // Log pour debug en production
        error_log("InfoForm {$infoFormId} status: " . ($status?->value ?? 'null'));

        return $dto;
    }

    private function getInfoFormCompanyStatus(array $uriVariables): InfoFormDTO
    {
        $infoFormCompanyId = $uriVariables['infoFormCompanyId'] ?? null;
        if (!$infoFormCompanyId) {
            throw new BadRequestHttpException('InfoFormCompany ID is required');
        }

        try {
            $infoFormCompany = $this->infoFormCompanyRepository->find($infoFormCompanyId);
            if (!$infoFormCompany) {
                throw new NotFoundHttpException('InfoFormCompany not found');
            }

            $dto = new InfoFormDTO();
            $dto->id = 'company_status_' . $infoFormCompanyId;
            $dto->companyStatus = $infoFormCompany->getStatus()->value;

            return $dto;

        } catch (\Exception $e) {
            // Fallback en cas de problème
            $dto = new InfoFormDTO();
            $dto->id = 'company_status_' . $infoFormCompanyId;
            $dto->companyStatus = 'Validé'; // Valeur par défaut

            return $dto;
        }
    }

    private function getInfoFormInternStatus(array $uriVariables): InfoFormDTO
    {
        $infoFormInternId = $uriVariables['infoFormInternId'] ?? null;
        if (!$infoFormInternId) {
            throw new BadRequestHttpException('InfoFormIntern ID is required');
        }

        try {
            $infoFormIntern = $this->infoFormInternRepository->find($infoFormInternId);
            if (!$infoFormIntern) {
                throw new NotFoundHttpException('InfoFormIntern not found');
            }

            $dto = new InfoFormDTO();
            $dto->id = 'intern_status_' . $infoFormInternId;
            $dto->internStatus = $infoFormIntern->getStatus()->value;

            return $dto;

        } catch (\Exception $e) {
            // Fallback en cas de problème
            $dto = new InfoFormDTO();
            $dto->id = 'intern_status_' . $infoFormInternId;
            $dto->internStatus = \App\Enum\InfoFormStatus::COMPLETED_INTERN_VALIDATION->value;

            return $dto;
        }
    }

    private function getInfoFormOrganizationStatus(array $uriVariables): InfoFormDTO
    {
        $infoFormOrganizationId = $uriVariables['infoFormOrganizationId'] ?? null;
        if (!$infoFormOrganizationId) {
            throw new BadRequestHttpException('InfoFormOrganization ID is required');
        }

        try {
            $infoFormOrganization = $this->infoFormOrganizationRepository->find($infoFormOrganizationId);
            if (!$infoFormOrganization) {
                throw new NotFoundHttpException('InfoFormOrganization not found');
            }

            $dto = new InfoFormDTO();
            $dto->id = 'organization_status_' . $infoFormOrganizationId;
            $dto->organizationStatus = $infoFormOrganization->getStatus()->value;

            return $dto;

        } catch (\Exception $e) {
            // Fallback en cas de problème
            $dto = new InfoFormDTO();
            $dto->id = 'organization_status_' . $infoFormOrganizationId;
            $dto->organizationStatus = \App\Enum\InfoFormStatus::COMPLETED_ORGANIZATION_VALIDATION->value;

            return $dto;
        }
    }

    private function getInternshipDates(array $uriVariables): InfoFormDTO
    {
        $trainingSessionId = $uriVariables['trainingSessionId'] ?? null;
        if (!$trainingSessionId) {
            throw new BadRequestHttpException('TrainingSession ID is required');
        }

        $trainingSession = $this->trainingSessionRepository->find($trainingSessionId);
        if (!$trainingSession) {
            throw new NotFoundHttpException('TrainingSession not found');
        }

        $internshipPeriodStart = $trainingSession->getInternShipPeriodStart();
        $internshipPeriodEnd = $trainingSession->getInternshipPeriodEnd();

        $dto = new InfoFormDTO();
        $dto->id = 'internship_dates_' . $trainingSessionId;
        $dto->internshipPeriodStart = $internshipPeriodStart ? $internshipPeriodStart->format('Y-m-d') : null;
        $dto->internshipPeriodEnd = $internshipPeriodEnd ? $internshipPeriodEnd->format('Y-m-d') : null;

        return $dto;
    }

    private function getTrainingDates(array $uriVariables): InfoFormDTO
    {
        $trainingSessionId = $uriVariables['trainingSessionId'] ?? null;
        if (!$trainingSessionId) {
            throw new BadRequestHttpException('TrainingSession ID is required');
        }

        $trainingSession = $this->trainingSessionRepository->find($trainingSessionId);
        if (!$trainingSession) {
            throw new NotFoundHttpException('TrainingSession not found');
        }

        $trainingPeriodStart = $trainingSession->getTrainingPeriodStart();
        $trainingPeriodEnd = $trainingSession->getTrainingPeriodEnd();

        $dto = new InfoFormDTO();
        $dto->id = 'training_dates_' . $trainingSessionId;
        $dto->trainingPeriodStart = $trainingPeriodStart ? $trainingPeriodStart->format('Y-m-d') : null;
        $dto->trainingPeriodEnd = $trainingPeriodEnd ? $trainingPeriodEnd->format('Y-m-d') : null;

        return $dto;
    }

    private function getPercentageFormValidation(array $uriVariables): InfoFormDTO
    {
        $trainingSessionId = $uriVariables['trainingSessionId'] ?? null;
        if (!$trainingSessionId) {
            throw new BadRequestHttpException('TrainingSession ID is required');
        }

        $trainingSession = $this->trainingSessionRepository->find($trainingSessionId);
        if (!$trainingSession) {
            throw new NotFoundHttpException('TrainingSession not found');
        }

        $infoForms = $trainingSession->getInfoForms();

        $totalFormsWithStatus = 0;
        $validatedForms = 0;

        foreach ($infoForms as $infoForm) {
            if ($infoForm->getStatus() !== null) {
                $totalFormsWithStatus++;

                $status = $infoForm->getStatus();
                if ($status === InfoFormStatus::FULLY_COMPLETED) {
                    $validatedForms++;
                }
            }
        }

        $validationPercentage = $totalFormsWithStatus > 0
            ? ($validatedForms / $totalFormsWithStatus) * 100
            : 0;

        $dto = new InfoFormDTO();
        $dto->id = 'validation_percentage_' . $trainingSessionId;
        $dto->validationPercentage = round($validationPercentage, 2);
        $dto->totalFormsWithStatus = $totalFormsWithStatus;
        $dto->validatedForms = $validatedForms;
        $dto->sessionName = $trainingSession->getTraining()?->getName() ?? 'Session ' . $trainingSessionId;

        return $dto;
    }
}
