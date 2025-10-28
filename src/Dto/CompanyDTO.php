<?php

namespace App\Dto;

use ApiPlatform\Metadata\Patch;
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
            uriTemplate: '/company/infoForm/{infoFormId}/infoFormCompany/',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId']],
            name: 'company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
            provider: CompanyProvider::class,
        ),


        new Patch(
            uriTemplate: '/company/infoForm/{infoFormId}/infoFormCompany/',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit']],
            denormalizationContext: ['groups' => ['denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit']],
            read: false,
            name: 'company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
            processor: CompanyProcessor::class
        ),

        new Patch(
            uriTemplate: '/company/infoForm/{infoFormId}/infoFormCompany/validation',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation']],
            denormalizationContext: ['groups' => ['denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation']],
            read: false,
            name: 'company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
            processor: CompanyProcessor::class
        ),
    ],
)]
class CompanyDTO
{

    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_validation',

    ])]
    public ?int $infoFormId = null;

    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?int $infoFormCompanyId = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $name = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $address = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $activity = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $phoneNumber = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $email = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $fax = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $siret = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $legalRepresentativeFirstName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $legalRepresentativeLastName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $legalRepresentativeEmail = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $tutorFirstName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $tutorLastName = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $tutorEmail = null;

    #[Groups([
        'read:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId',
        'update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit',
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?string $tutorPhoneNumber = null;


// status
    #[Groups([
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?InfoFormStatus $infoFormStatus = null;

    #[Groups([
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?InfoFormCompanyStatus $infoFormCompanyStatus = null;

    #[Groups([
        'update:update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
        'denorm-update:company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_validation',
    ])]
    public ?InfoFormOrganizationStatus $infoFormOrganizationStatus = null;
}
