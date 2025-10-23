<?php

namespace App\Dto;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\State\OrganizationProcessor;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Enum\InfoFormStatus;
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
            uriTemplate: '/organization/session/{sessionId}',
            provider: \App\State\OrganizationProvider::class,
            name: 'organization_session_detail',
            normalizationContext: ['groups' => ['read:organization_session_detail']],
        ),
        new Patch(
            uriTemplate: '/organization/session/{sessionId}/edit',
            provider: \App\State\OrganizationProvider::class, // obligatoire pour charger la ressource
            processor: OrganizationProcessor::class, // gère la mise à jour
            name: 'organization_session_edit',
            denormalizationContext: ['groups' => ['update:organization_session']],
        ),

        new GetCollection(
            uriTemplate: '/organization/session/{sessionId}/interns',
            provider: \App\State\OrganizationProvider::class,
            name: 'organization_session_interns',
            normalizationContext: ['groups' => ['read:organization_session_interns']],
        ),

        // new Get(
        //     uriTemplate: '/organization/session/{sessionId}/interns/{internId}',
        //     provider: \App\State\OrganizationProvider::class,
        //     name: 'organization_session_intern_detail',
        //     normalizationContext: ['groups' => ['read:organization_session_intern_detail']],
        // )
        // new Delete(),
    ],
    processor: null
)]
class OrganizationDTO
{
    #[ApiProperty(identifier: true)]
    public ?int $sessionId = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_session_detail',
        'update:organization_session',
    ])]
    public ?string $name = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_session_detail',
        'update:organization_session',

    ])]
    public ?\DateTimeInterface $startDate = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_session_detail',
        'update:organization_session',
    ])]
    public ?\DateTimeInterface $endDate = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_session_detail',
        'update:organization_session',
    ])]
    public ?string $offerNumber = null;

    #[Groups([
        'read:organization_session_interns',
    ])]
    public ?string $internFirstName = null;

    #[Groups([
        'read:organization_session_interns',
    ])]
    public ?string $internLastName = null;

    #[Groups([
        'read:organization_session_interns',
    ])]
    public ?string $internLogin = null;

    // #[Groups([
    //     'read:organization_session_interns',
    // ])]
    // public ?array $infoForms = null;

    #[Groups([
        'read:organization_session_interns',
    ])]
    public ?string $infoFormStatus = null;
}
