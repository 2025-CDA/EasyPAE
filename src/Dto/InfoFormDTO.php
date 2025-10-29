<?php

namespace App\Dto;

use DateTimeImmutable;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\State\InfoFormProvider;
use App\State\InfoFormProcessor;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/resum-form/{infoFormId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:full_resume_form']],
            name: 'full_resume_form',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/resume-card/{infoFormId}/intern',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:intern_resume']],
            name: 'intern_resume_card',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/resume-card/{infoFormId}/organization',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:organization_resume']],
            name: 'organization_resume_card',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/resume-card/{infoFormId}/company',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:company_resume']],
            name: 'company_resume_card',
            provider: InfoFormProvider::class,
        ),

        new Patch(
            uriTemplate: '/resum-form/{infoFormId}/validation-status',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:validation_status']],
            read: false,
            name: 'validate_resume_form',
            processor: InfoFormProcessor::class,
        ),

        new Get(
            uriTemplate: '/status/{infoFormId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:info_form_status']],
            name: 'info_form_status',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/status/company/{infoFormCompanyId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormCompanyId'],
            normalizationContext: ['groups' => ['read:company_status']],
            name: 'info_form_company_status',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/status/intern/{infoFormInternId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormInternId'],
            normalizationContext: ['groups' => ['read:intern_status']],
            name: 'info_form_intern_status',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/status/organization/{infoFormOrganizationId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormOrganizationId'],
            normalizationContext: ['groups' => ['read:organization_status']],
            name: 'info_form_organization_status',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/internship-dates/{trainingSessionId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['trainingSessionId'],
            normalizationContext: ['groups' => ['read:internship_dates']],
            name: 'internship_dates',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/training-dates/{trainingSessionId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['trainingSessionId'],
            normalizationContext: ['groups' => ['read:training_dates']],
            name: 'training_dates',
            provider: InfoFormProvider::class,
        ),

        new Get(
            uriTemplate: '/percentage-form-validation/{trainingSessionId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['trainingSessionId'],
            normalizationContext: ['groups' => ['read:validation_percentage']],
            name: 'percentage_form_validation',
            provider: InfoFormProvider::class,
        ),
    ],
)]
class InfoFormDTO
{
    #[ApiProperty(identifier: true)]
    public ?string $id = null;

    // Propriétés pour intern resume card
    #[Groups(['read:intern_resume'])]
    public ?string $internAvatar = null;

    #[Groups(['read:intern_resume'])]
    public ?string $internFirstName = null;

    #[Groups(['read:intern_resume'])]
    public ?string $internLastName = null;

    #[Groups(['read:intern_resume'])]
    public ?string $internLogin = null;

    #[Groups(['read:intern_resume'])]
    public ?string $internEmail = null;

    #[Groups(['read:intern_resume'])]
    public ?string $trainingTitle = null;

    #[Groups(['read:intern_resume'])]
    public ?string $offerNumber = null;

    #[Groups(['read:intern_resume'])]
    public ?string $organizationUserFirstName = null;

    #[Groups(['read:intern_resume'])]
    public ?string $organizationUserLastName = null;

    #[Groups(['read:intern_resume'])]
    public ?\DateTimeInterface $internshipStartDate = null;

    #[Groups(['read:intern_resume'])]
    public ?\DateTimeInterface $internshipEndDate = null;

    // Propriétés pour organization resume card
    #[Groups(['read:organization_resume'])]
    public ?string $organizationUserAvatar = null;

    #[Groups(['read:organization_resume'])]
    public ?string $organizationName = null;

    // Propriétés pour company resume card
    #[Groups(['read:company_resume'])]
    public ?string $companyUserAvatar = null;

    #[Groups(['read:company_resume'])]
    public ?string $companyName = null;

    #[Groups(['read:company_resume'])]
    public ?string $companyAddress = null;

    #[Groups(['read:company_resume'])]
    public ?string $companyContactEmail = null;

    #[Groups(['read:company_resume'])]
    public ?string $companyPhoneNumber = null;

    #[Groups(['read:company_resume'])]
    public ?string $tutorName = null;

    // Propriétés pour le formulaire (resum-form)
    #[Groups(['read:full_resume_form'])]
    public ?string $internFirstNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $internLastNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $internEmailFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $trainingNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $trainingOfferNumberFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?\DateTimeInterface $internshipStartDateFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?\DateTimeInterface $internshipEndDateFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companyNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companyAddressFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companyContactEmailFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companyContactNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companyPhoneNumberFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companyEmailFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companyFaxFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $companySiretFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $legalResponsibleLastNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $legalResponsibleFirstNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $legalResponsibleEmailFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $tutorLastNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $tutorFirstNameFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $tutorEmailFull = null;

    #[Groups(['read:full_resume_form'])]
    public ?string $tutorPhoneFull = null;

    // Propriétés pour la validation du statut
    #[Groups(['read:validation_status'])]
    public ?string $validationMessage = null;

    // Propriétés pour les statuts
    #[Groups(['read:info_form_status'])]
    public ?string $infoFormStatus = null;

    #[Groups(['read:company_status'])]
    public ?string $companyStatus = null;

    #[Groups(['read:intern_status'])]
    public ?string $internStatus = null;

    #[Groups(['read:organization_status'])]
    public ?string $organizationStatus = null;

    // Propriétés pour les dates de stage
    #[Groups(['read:internship_dates'])]
    public ?string $internshipPeriodStart = null;

    #[Groups(['read:internship_dates'])]
    public ?string $internshipPeriodEnd = null;

    // Propriétés pour les dates de formation
    #[Groups(['read:training_dates'])]
    public ?string $trainingPeriodStart = null;

    #[Groups(['read:training_dates'])]
    public ?string $trainingPeriodEnd = null;

    // Propriétés pour le pourcentage de validation des stages
    #[Groups(['read:validation_percentage'])]
    public ?float $validationPercentage = null;

    #[Groups(['read:validation_percentage'])]
    public ?int $totalFormsWithStatus = null;

    #[Groups(['read:validation_percentage'])]
    public ?int $validatedForms = null;

    #[Groups(['read:validation_percentage'])]
    public ?string $sessionName = null;

    #[Groups([
        'read:info_form_status',
        'read:company_status',
        'read:intern_status',
        'read:organization_status'
    ])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d-H-i'])]
    public ?DateTimeImmutable $updated_at = null;
}
