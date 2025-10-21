<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\State\TestProvider;

#[ApiResource(
    operations: [

        new GetCollection(
            uriTemplate: '/organization/sessions',
            normalizationContext: ['groups' => ['read:organization_sessions_collection']]

        ),

        new GetCollection(
            uriTemplate: '/organization/session/{id}/interns',
            normalizationContext: ['groups' => ['read:organization_session_interns_collection']],
            uriVariables: [
                'id' => new Link(fromClass: self::class, identifiers: ['id']),
            ]
        ),
    ],
    // provider: TestProvider::class,
    // processor: null
)]
class OrganizationDTO
{
    #[ApiProperty(identifier: true)]
    public int $id;

    public string $userFullName;
}
