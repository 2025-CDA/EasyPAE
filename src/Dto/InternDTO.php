<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Entity\Organization;
use App\Enum\InfoFormStatus;
use App\State\OrganizationProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/intern/dashboard',
            uriVariables: ['organizationId' => new Link(fromClass: Organization::class,identifiers: ['id'])],
        ),
        
    ],
    provider: OrganizationProvider::class,
    processor: null
)]
class InternDTO
{
//    #[ApiProperty(identifier: true)]
    public int $id;

    public InfoFormStatus $status;

    public array $infoFormInternCompany;

    public \DateTimeInterface $internshipStartDate;

    public \DateTimeInterface $internshipEndDate;


}
