<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\InfoFormCompanyStatus;
use App\Enum\InfoFormInternStatus;
use App\Enum\InfoFormOrganizationStatus;
use App\Enum\InfoFormStatus;
use App\State\InternProcessor;
use App\State\InternProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [

        new Get(
            uriTemplate: '/intern/infoForm/{infoFormId}/infoFormIntern',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:intern_infoForm_infoFormId_infoFormIntern']],
            name: 'intern_infoForm_infoFormId_infoFormIntern',
            provider: InternProvider::class,
        ),

        new Get(
            uriTemplate: '/intern/{userId}/infoForms',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['userId'],
            normalizationContext: ['groups' => ['read:intern_userId_infoForms']],
            name: 'intern_userId_infoForms',
            provider: InternProvider::class,
        ),

        new Get(
            uriTemplate: '/intern/infoForm/{infoFormId}/infoFormInternCompany',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:intern_infoForm_infoFormId_infoFormInternCompany']],
            name: 'intern_infoForm_infoFormId_infoFormInternCompany',
            provider: InternProvider::class,
        ),


        new Post(
            uriTemplate: '/intern/infoForm',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            normalizationContext: ['groups' => ['create:intern_infoForm_add']],
            denormalizationContext: ['groups' => ['denorm-create:intern_infoForm_add']],
            name: 'intern_infoForm_add',
            processor: InternProcessor::class,
        ),


        new Patch(
            uriTemplate: '/intern/infoForm/{infoFormId}/infoFormIntern',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:intern_infoForm_infoFormId_infoFormIntern_edit']],
            denormalizationContext: ['groups' => ['denorm-update:intern_infoForm_infoFormId_infoFormIntern_edit']],
            read: false,
            name: 'intern_infoForm_infoFormId_infoFormIntern_edit',
            processor: InternProcessor::class
        ),

        new Patch(
            uriTemplate: '/intern/infoForm/{infoFormId}/infoFormIntern/infoFormInternCompany',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit']],
            denormalizationContext: ['groups' => ['denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit']],
            read: false,
            name: 'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
            processor: InternProcessor::class
        ),

        new Patch(
            uriTemplate: '/intern/infoForm/{infoFormId}/infoFormIntern/validation',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation']],
            denormalizationContext: ['groups' => ['denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation']],
            read: false,
            name: 'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
            processor: InternProcessor::class
        ),
    ],
)]
class InternDTO
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'update:intern_infoForm_infoFormId_infoFormIntern_edit',
    ])]
    public ?int $infoFormInternId = null;

    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:intern_userId_infoForms',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
        'create:intern_infoForm_add',
    ])]
    public ?int $infoFormId = null;

    // #[Groups([
    //     'denorm-create:intern_infoForm_add',
    // ])]
    // public ?int $trainingSessionId = null;


    // #[Groups([
    //     'denorm-create:intern_infoForm_add',
    // ])]
    // public ?int $organizationId = null;

    #[Groups([
        'denorm-create:intern_infoForm_add',
    ])]
    public ?int $internId = null;


    #[Groups([
        'read:intern_userId_infoForms',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
    ])]
    public ?InfoFormStatus $infoFormStatus = null;

    // #[Groups([
    //     'denorm-create:intern_infoForm_add',
    // ])]
    // public ?int $infoFormOrganizationId = null;

    // #[Groups([
    //     'denorm-create:intern_infoForm_add',
    // ])]
    // public ?InfoFormOrganizationStatus $infoFormOrganizationStatus = null;

    #[Groups([
        'read:intern_userId_infoForms',
        'update:intern_infoForm_infoFormId_infoFormIntern_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_edit',
    ])]
    public ?\DateTimeInterface $infoFormInternDateStart = null;

    #[Groups([
        'read:intern_userId_infoForms',
        'update:intern_infoForm_infoFormId_infoFormIntern_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_edit',
    ])]
    public ?\DateTimeInterface $infoFormInternDateEnd = null;

    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
    ])]
    public ?InfoFormInternStatus $infoFormInternStatus = null;

    // #[Groups([
    //     'denorm-create:intern_infoForm_add',
    // ])]
    // public ?int $infoFormInternCompanyId = null;

    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
    ])]
    public ?InfoFormCompanyStatus $infoFormCompanyStatus = null;

    // #[Groups([
    //     'denorm-create:intern_infoForm_add',
    // ])]
    // public ?int $infoFormCompanyId = null;

    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'read:intern_infoForm_infoFormId_infoFormInternCompany',
    ])]
    public ?string $infoFormInternCompanyName = null;

    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'read:intern_infoForm_infoFormId_infoFormInternCompany',
    ])]
    public ?string $infoFormInternCompanyAddress = null;

    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'read:intern_infoForm_infoFormId_infoFormInternCompany',
    ])]
    public ?string $infoFormInternCompanyLegalRepresentativeFirstName = null;

    // FirstName + LastName = companyContactName
    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'read:intern_infoForm_infoFormId_infoFormInternCompany',
    ])]
    public ?string $infoFormInternCompanyLegalRepresentativeLastName = null;

    // This is the contact email
    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'read:intern_infoForm_infoFormId_infoFormInternCompany',
    ])]
    public ?string $infoFormInternCompanyLegalRepresentativeEmail = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'create:intern_infoForm_add',
    ])]
    public ?string $internFirstName = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'create:intern_infoForm_add',
    ])]
    public ?string $internLastName = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'create:intern_infoForm_add',
    ])]
    public ?string $internEmail = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'create:intern_infoForm_add',
    ])]
    public ?string $trainingName = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'create:intern_infoForm_add',
    ])]
    public ?string $offerNumber = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'create:intern_infoForm_add',
    ])]
    public ?\DateTimeInterface $internshipStart = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
        'create:intern_infoForm_add',
    ])]
    public ?\DateTimeInterface $internshipEnd = null;

    // Nouvelles propriétés pour la liste des infoForms
    #[Groups([
        'read:intern_userId_infoForms',
    ])]
    public ?string $companyUserAvatar = null;

    #[Groups([
        'read:intern_userId_infoForms',
    ])]
    public ?string $companyName = null;

    #[Groups([
        'read:intern_userId_infoForms',
    ])]
    public ?string $companyAddress = null;

    #[Groups([
        'read:intern_userId_infoForms',
    ])]
    public ?string $companyPhoneNumber = null;

    #[Groups([
        'read:intern_userId_infoForms',
    ])]
    public ?string $infoFormCompanyContactEmail = null;

    #[Groups([
        'read:intern_userId_infoForms',
    ])]
    public ?string $infoFormCompanyTutorFirstName = null;

    #[Groups([
        'read:intern_userId_infoForms',
    ])]
    public ?string $infoFormCompanyTutorLastName = null;

}
