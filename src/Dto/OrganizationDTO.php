<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/organization/sessions',
            provider: \App\State\OrganizationProvider::class,
            name: 'organization_sessions',
            normalizationContext: ['groups' => ['read:organization_sessions']],
        ),
        new Get(
            uriTemplate: '/organization/sessions/{id}',
            provider: \App\State\OrganizationProvider::class,
            name: 'organization_session_detail',
            normalizationContext: ['groups' => ['read:organization_session_detail']],
        ),
    ],
    processor: null
)]
class OrganizationDTO
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_session_detail'
    ])]
    public ?string $name = null;

    #[Groups(['read:organization_sessions'])]
    public ?\DateTimeInterface $startDate = null;

    #[Groups(['read:organization_sessions'])]
    public ?\DateTimeInterface $endDate = null;

    #[Groups(['read:organization_sessions'])]
    public ?string $offerNumber = null;
}
