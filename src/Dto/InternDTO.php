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


        new Post(
            uriTemplate: '/intern/infoForm',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            normalizationContext: ['groups' => ['read:intern_infoForm_infoFormId_infoFormIntern']],
            denormalizationContext: ['groups' => ['create:intern_infoForm_add']],
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
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_edit',
    ])]
    public ?int $infoFormInternId = null;

    // #[ApiProperty(identifier: true)]
    #[Groups([
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
    ])]
    public ?int $infoFormId = null;

    // #[Groups([
    //     'create:intern_infoForm_add',
    // ])]
    // public ?int $trainingSessionId = null;


    // #[Groups([
    //     'create:intern_infoForm_add',
    // ])]
    // public ?int $organizationId = null;

    #[Groups([
        'create:intern_infoForm_add',
    ])]
    public ?int $internId = null;


    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
    ])]
    public ?InfoFormStatus $infoFormStatus = null;

    // #[Groups([
    //     'create:intern_infoForm_add',
    // ])]
    // public ?int $infoFormOrganizationId = null;

    // #[Groups([
    //     'create:intern_infoForm_add',
    // ])]
    // public ?InfoFormOrganizationStatus $infoFormOrganizationStatus = null;

    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_edit',
    ])]
    public ?\DateTimeInterface $infoFormInternDateStart = null;

    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_edit',
    ])]
    public ?\DateTimeInterface $infoFormInternDateEnd = null;

    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
    ])]
    public ?InfoFormInternStatus $infoFormInternStatus = null;

    // #[Groups([
    //     'create:intern_infoForm_add',
    // ])]
    // public ?int $infoFormInternCompanyId = null;

    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation',
    ])]
    public ?InfoFormCompanyStatus $infoFormCompanyStatus = null;

    // #[Groups([
    //     'create:intern_infoForm_add',
    // ])]
    // public ?int $infoFormCompanyId = null;

    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
    ])]
    public ?string $infoFormInternCompanyName = null;

    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
    ])]
    public ?string $infoFormInternCompanyAddress = null;

    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
    ])]
    public ?string $infoFormInternCompanyLegalRepresentativeFirstName = null;

    // FirstName + LastName = companyContactName
    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
    ])]
    public ?string $infoFormInternCompanyLegalRepresentativeLastName = null;

    // This is the contact email
    #[Groups([
        // 'create:intern_infoForm_add',
        'update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
        'denorm-update:intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit',
    ])]
    public ?string $infoFormInternCompanyLegalRepresentativeEmail = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
    ])]
    public ?string $internFirstName = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
    ])]
    public ?string $internLastName = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
    ])]
    public ?string $internEmail = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
    ])]
    public ?string $trainingName = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
    ])]
    public ?string $offerNumber = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
    ])]
    public ?\DateTimeInterface $internshipStart = null;

    #[Groups([
        'read:intern_infoForm_infoFormId_infoFormIntern',
    ])]
    public ?\DateTimeInterface $internshipEnd = null;

}
