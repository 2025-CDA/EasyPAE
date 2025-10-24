<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use App\Entity\InternMember;
use App\Enum\InfoFormStatus;
use App\State\InternProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/intern/{id}/dashboard/',
            normalizationContext: ['groups' => ['read:intern_dashboard_detail']],
            name: 'intern_dashboard_detail',
            provider: InternProvider::class,
        ),
    ],
    processor: null
)]
class InternDTO
{

//    #[ApiProperty(identifier: true)]
//    #[Groups([
//
//    ])]
//    public ?int $trainingSessionId = null;
//
//    #[ApiProperty(identifier: true)]
//    #[Groups([
//
//    ])]
//    public ?int $organizationId = null;
//
//    #[ApiProperty(identifier: true)]
//    #[Groups([
//
//    ])]
//    public ?int $internId = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $infoFormStatus = null;
//
//    #[Groups([
//
//    ])]
//    public ?int $infoFormOrganizationId = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $infoFormOrganizationStatus = null;
//
//    #[Groups([
//
//    ])]
//    public ?int $inforFormInternMemberId = null;
//
//    #[Groups([
//
//    ])]
//    public ?\DateTimeInterface $inforFormInternMemberDateStart = null;
//
//    #[Groups([
//
//    ])]
//    public ?\DateTimeInterface $inforFormInternMemberDateEnd = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $inforFormInternMemberStatus = null;
//
//    #[Groups([
//
//    ])]
//    public ?int $infoFormInternCompanyId = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $infoFormCompanyStatus = null;
//
//    #[Groups([
//
//    ])]
//    public ?int $infoFormCompanyId = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $infoFormInternCompanyLegalRepresentativeFirstName = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $infoFormInternCompanyLegalRepresentativeLastName = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $infoFormInternCompanyLegalRepresentativeEmail = null;
//
//    #[Groups([
//
//    ])]
//    public ?string $infoFormInternCompanyName = null;

}
