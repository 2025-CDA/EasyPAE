<?php

namespace App\Dto;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\State\OrganizationProcessor;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Enum\InfoFormStatus;
use App\State\OrganizationProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [

        new GetCollection(
            uriTemplate: '/organization/sessions',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            normalizationContext: ['groups' => ['read:organization_sessions']],
            name: 'organization_sessions',
            provider: OrganizationProvider::class,
        ),

        new GetCollection(
            uriTemplate: '/organization/training-names',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            normalizationContext: ['groups' => ['read:organization_training_names']],
            name: 'organization_training_names',
            provider: OrganizationProvider::class,
        ),

        new GetCollection(
            uriTemplate: '/organization/{organizationMemberId}/sessions',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['organizationMemberId'],
            normalizationContext: ['groups' => ['read:organization_organizationMemberId_sessions']],
            name: 'organization_organizationMemberId_sessions',
            provider: OrganizationProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/organization/session/{sessionId}/interns',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['sessionId'],
            normalizationContext: ['groups' => ['read:organization_session_sessionId_interns']],
            name: 'organization_session_sessionId_interns',
            provider: OrganizationProvider::class,
        ),


        new Get(
            uriTemplate: '/organization/session/{sessionId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['sessionId'],
            normalizationContext: ['groups' => ['read:organization_session_sessionId']],
            name: 'organization_session_sessionId',
            provider: OrganizationProvider::class,
        ),


        new Post(
            uriTemplate: '/organization/session',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            denormalizationContext: ['groups' => ['create:organization_session_add']],
            name: 'organization_session_add',
            processor: OrganizationProcessor::class,
        ),
        new Post(
            uriTemplate: '/organization/session/{sessionId}/intern',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['sessionId'],
            normalizationContext: ['groups' => ['create:organization_session_sessionId_intern_add']],
            denormalizationContext: ['groups' => ['denorm-create:organization_session_sessionId_intern_add']],
            name: 'organization_session_sessionId_intern_add',
            processor: OrganizationProcessor::class,
            // read: false,
            // output: false,
        ),


        new Patch(
            uriTemplate: '/organization/session/{sessionId}',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['sessionId'],
            normalizationContext: ['groups' => ['update:organization_session_sessionId_edit']],
            denormalizationContext: ['groups' => ['denorm-update:organization_session_sessionId_edit']],
            read: false,
            name: 'organization_session_sessionId_edit',
            processor: OrganizationProcessor::class,
        ),
        new Patch(
            uriTemplate: '/organization/session/{sessionId}/archive',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['sessionId'],
            normalizationContext: ['groups' => ['update:organization_session_sessionId_archive']],
            denormalizationContext: ['groups' => ['denorm-update:organization_session_sessionId_archive']],
            read: false,
            name: 'organization_session_sessionId_archive',
            processor: OrganizationProcessor::class,
        ),
        new Patch(
            uriTemplate: '/organization/infoForm/{infoFormId}/sign',
            formats: ['jsonld' => ['application/ld+json'], 'json' => ['application/json']],
            uriVariables: ['infoFormId'],
            normalizationContext: ['groups' => ['update:organization_infoForm_infoFormId_sign']],
            denormalizationContext: ['groups' => ['denorm-update:organization_infoForm_infoFormId_sign']],
            read: false,
            name: 'organization_infoForm_infoFormId_sign',
            processor: OrganizationProcessor::class,
        ),
    ],
)]
class OrganizationDTO
{
    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
        'update:organization_session_sessionId_edit',
        'read:organization_session_sessionId_interns',
        'update:organization_session_sessionId_archive',
        'read:organization_training_names'

    ])]
    public ?int $sessionId = null;

    #[ApiProperty(identifier: true)]
    #[Groups([
        'read:organization_organizationMemberId_sessions',
    ])]
    public ?int $organizationMemberId = null;


    #[Groups([
        'create:organization_session_sessionId_intern_add'
        //        TODO: change this later, this is just for testing.
    ])]
    public ?string $plainPassword = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_session_sessionId',
        'read:organization_organizationMemberId_sessions',
        'create:organization_session_add',
        'update:organization_session_sessionId_edit',
        'denorm-update:organization_session_sessionId_edit',
    ])]
    public ?int $trainerId = null;

    #[Groups([
        'read:organization_session_sessionId_interns',
    ])]
    public ?int $internId = null;

    #[Groups([
        'read:organization_sessions',
    ])]
    public ?int $trainingId = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
        'read:organization_session_sessionId',
        'create:organization_session_add',
        'update:organization_session_sessionId_edit',
        'denorm-update:organization_session_sessionId_edit',
        'read:organization_session_sessionId_interns',
        'read:organization_training_names'
    ])]
    public ?string $trainingName = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
        'read:organization_session_sessionId',
        'create:organization_session_add',
        'update:organization_session_sessionId_edit',
        'denorm-update:organization_session_sessionId_edit',
    ])]
    public ?string $offerNumber = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
    ])]
    public ?string $trainerFirstName = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
    ])]
    public ?string $trainerLastName = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
        'read:organization_session_sessionId',
        'create:organization_session_add',
        'update:organization_session_sessionId_edit',
        'denorm-update:organization_session_sessionId_edit',
    ])]
    public ?\DateTimeInterface $internshipStart = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
        'read:organization_session_sessionId',
        'create:organization_session_add',
        'update:organization_session_sessionId_edit',
        'denorm-update:organization_session_sessionId_edit',
    ])]
    public ?\DateTimeInterface $internshipEnd = null;

    #[Groups([
        'read:organization_sessions',
        'read:organization_organizationMemberId_sessions',
    ])]
    public ?int $validationPercentage = null;

    #[Groups([
        'read:organization_session_sessionId_interns',
        'denorm-create:organization_session_sessionId_intern_add',
    ])]
    public ?string $internFirstName = null;

    #[Groups([
        'read:organization_session_sessionId_interns',
        'denorm-create:organization_session_sessionId_intern_add',
    ])]
    public ?string $internLastName = null;

    #[Groups([
        'read:organization_session_sessionId_interns',
        'denorm-create:organization_session_sessionId_intern_add',
    ])]
    public ?string $internLogin = null;

    #[Groups([
        'denorm-create:organization_session_sessionId_intern_add',
    ])]
    public ?string $internEmail = null;

    #[Groups([
        'read:organization_session_sessionId_interns',
    ])]
    public ?InfoFormStatus $infoFormStatus = null;

    #[Groups([
        'update:organization_session_sessionId_archive',
    ])]
    public ?bool $hasEnded = null;

    #[Groups([
        'update:organization_infoForm_infoFormId_sign',
        'read:organization_session_sessionId_interns',
    ])]
    public ?int $infoFormId = null;

    #[Groups([
        'denorm-update:organization_infoForm_infoFormId_sign',
    ])]
    public ?string $signature = null;

    #[Groups([
        'denorm-update:organization_infoForm_infoFormId_sign',
    ])]
    public ?\DateTimeInterface $validationDate = null;

    #[Groups([
        'create:organization_session_add',
        'read:organization_session_sessionId',
        'read:organization_sessions',

    ])]
    public ?\DateTimeImmutable $trainingPeriodStart = null;

    #[Groups([
        'create:organization_session_add',
        'read:organization_session_sessionId',
        'read:organization_sessions',

    ])]
    public ?\DateTimeImmutable $trainingPeriodEnd = null;

    #[Groups([
        'read:organization_session_sessionId',
        'read:organization_sessions',
    ])]
    public ?string $category = null;
}
