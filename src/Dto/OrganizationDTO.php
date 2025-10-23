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
use App\State\OrganizationProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
//        new GetCollection(
//            uriTemplate: '/organization/sessions',
//            normalizationContext: ['groups' => ['read:organization_sessions']],
//            name: 'organization_sessions',
//            provider: OrganizationProvider::class,
//        ),
        new Get(
            uriTemplate: '/organization/session/{sessionId}',
            normalizationContext: ['groups' => ['read:organization_session_detail']],
            name: 'organization_session_detail',
            provider: OrganizationProvider::class,
        ),
//        new Patch(
//            uriTemplate: '/organization/session/{sessionId}/edit',
//            denormalizationContext: ['groups' => ['update:organization_session']], // obligatoire pour charger la ressource
//            name: 'organization_session_edit', // gère la mise à jour
////            provider: OrganizationProvider::class,
//            processor: OrganizationProcessor::class,
//        ),

        new GetCollection(
            uriTemplate: '/organization/session/{sessionId}/interns',
            normalizationContext: ['groups' => ['read:organization_session_interns']],
            name: 'organization_session_interns',
            provider: OrganizationProvider::class,
        ),

//         new Get(
//             uriTemplate: '/organization/session/{sessionId}/intern/{internId}',
//             normalizationContext: ['groups' => ['read:organization_session_intern_detail']],
//             name: 'organization_session_intern_detail',
//             provider: \App\State\OrganizationProvider::class,
//         ),
//         new Delete(),
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
