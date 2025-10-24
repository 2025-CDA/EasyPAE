<?php

namespace App\Dto;

use App\Enum\Gender;
use App\Enum\WorkLocation;
use App\Enum\InfoFormStatus;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use App\State\CompanyProvider;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Company;
use App\Entity\InfoFormInternCompany;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
   operations: [
        // new Get(
        //     uriTemplate: '/company/{id}/dashboard',
        //     provider: CompanyProvider::class,
        //     name: 'company_dashboard',
        //     normalizationContext: ['groups' => ['read:company_dashboard']],
        // ),
        new Get( 
            uriTemplate: '/company/form/{id}',
            provider: CompanyProvider::class,
            name: 'company_form',
            normalizationContext: ['groups' => ['read:info_form_company']],
       ),
   ],
   processor: null
)]

class CompanyDTO
{

    #[ApiProperty(identifier: true)]

    // #[Groups(['read:company_dashboard'])]
    public ?int $id = null;

    #[Groups(['read:info_form_company'])]
    public ?string $fax = null;

    #[Groups(['read:info_form_company'])]
    public ?string $activity = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $activityDescription = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $stamp = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?Gender $legalRepresentativeGender = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $legalRepresentativeLastName = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $legalRepresentativeFirstName = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $legalRepresentativeSignature = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $legalRepresentativeEmail = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?\DateTimeImmutable $interviewStartDateTime = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?\DateTimeImmutable $interviewEndDateTime = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?bool $agreeTerms = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?WorkLocation $workLocation = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?Gender $tutorGender = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $tutorFirstName = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $tutorLastName = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $tutorEmail = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $tutorPhoneNumber = null;

// status
    #[Groups(['read:company_dashboard'])]
    public ?InfoFormStatus $status = null;


// InfoFormInternCompany entity
   
    public ?int $idInfoFormInternCompany = null;

    #[Groups([
        'read:info_form_company',
    ])]
    public ?string $companyName = null;

   
    public ?string $address = null;

   
    public ?string $email = null;

   
    public ?string $contactName = null;


// Company entity
   
    public ?int $idCompany = null;

   
    public ?string $siret = null;

   
    public ?string $name = null;

   
    public ?string $phoneNumber = null;


}
