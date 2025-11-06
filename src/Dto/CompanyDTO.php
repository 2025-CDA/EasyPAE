<?php

namespace App\Dto;

use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Enum\InfoFormCompanyStatus;
use App\Enum\InfoFormOrganizationStatus;
use App\Enum\InfoFormStatus;
use ApiPlatform\Metadata\Get;
use App\State\CompanyProcessor;
use App\State\CompanyProvider;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/company/infoForm/{infoFormId}/infoFormCompany',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:company_infoForm_infoFormId_infoFormCompany']],
            name: 'company_infoForm_infoFormId_infoFormCompany',
            provider: CompanyProvider::class,
        ),

        new Get(
            uriTemplate: '/company/companyMember/{companyMemberId}/infoForms',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['companyMemberId'],
            normalizationContext: ['groups' => ['read:companyMember_companyMemberId_infoForms']],
            name: 'companyMember_companyMemberId_infoForms',
            provider: CompanyProvider::class,
        ),


//        new Post(
//            uriTemplate: '/intern/infoForm',
//            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
//            normalizationContext: ['groups' => ['read:intern_infoForm_infoFormId_infoFormIntern']],
//            denormalizationContext: ['groups' => ['create:intern_infoForm_add']],
//            name: 'intern_infoForm_add',
//            processor: CompanyProcessor::class,
//        ),


        new Patch(
            uriTemplate: '/company/infoForm/{infoFormId}/infoFormCompany',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:company_infoForm_infoFormId_infoFormCompany_edit']],
            denormalizationContext: ['groups' => ['denorm-update:company_infoForm_infoFormId_infoFormCompany_edit']],
            read: false,
            name: 'company_infoForm_infoFormId_infoFormCompany_edit',
            processor: CompanyProcessor::class
        ),

        new Patch(
            uriTemplate: '/company/infoForm/{infoFormId}/infoFormCompany/validation',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:company_infoForm_infoFormId_infoFormCompany_validation']],
            denormalizationContext: ['groups' => ['denorm-update:company_infoForm_infoFormId_infoFormCompany_validation']],
            read: false,
            name: 'company_infoForm_infoFormId_infoFormCompany_validation',
            processor: CompanyProcessor::class
        ),
    ],
)]
class CompanyDTO
{

    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'read:companyMember_companyMemberId_infoForms',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_validation',

    ])]
    public ?int $infoFormId = null;

    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?int $infoFormCompanyId = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $name = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $address = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $activity = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $phoneNumber = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $email = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $fax = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $siret = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $legalRepresentativeFirstName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $legalRepresentativeLastName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $legalRepresentativeEmail = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $tutorFirstName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $tutorLastName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $tutorEmail = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?string $tutorPhoneNumber = null;


// status
    #[Groups([
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
        'read:companyMember_companyMemberId_infoForms'
    ])]
    public ?InfoFormStatus $infoFormStatus = null;

    #[Groups([
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
        'read:companyMember_companyMemberId_infoForms'
    ])]
    public ?InfoFormCompanyStatus $infoFormCompanyStatus = null;

    #[Groups([
        'update:company_infoForm_infoFormId_infoFormCompany_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_validation',
    ])]
    public ?InfoFormOrganizationStatus $infoFormOrganizationStatus = null;

        // Nouvelles propriétés pour la liste des infoForms
    #[Groups([
        'read:company_companyId_infoForms',
        'read:companyMember_companyMemberId_infoForms',
    ])]
    public ?array $infoForms = null;

    #[Groups([
        'read:company_companyId_infoForms',
        'read:companyMember_companyMemberId_infoForms',
    ])]
    public ?int $companyMemberId = null;

    #[Groups([
        'read:company_companyId_infoForms',
        'read:companyMember_companyMemberId_infoForms',
    ])]
    public ?InfoFormCompanyStatus $companyStatus = null;

    #[Groups([
        'read:company_companyId_infoForms',
        'read:companyMember_companyMemberId_infoForms',
    ])]
    public ?string $internFirstName = null;

    #[Groups([
        'read:company_companyId_infoForms',
        'read:companyMember_companyMemberId_infoForms',
    ])]
    public ?string $internLastName = null;

    #[Groups([
        'read:company_companyId_infoForms',
        'read:companyMember_companyMemberId_infoForms',
    ])]
    public ?string $internEmail = null;
}
