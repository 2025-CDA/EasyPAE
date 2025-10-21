<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Entity\Organization;
use App\State\OrganizationProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/organization/{organizationId}/sessions',
            uriVariables: [
                'organizationId' => new Link(fromClass: Organization::class, identifiers: ['id'])
            ],
            provider: OrganizationProvider::class,
        )
    ],
    processor: null
)]
class OrganizationDTO
{
    /**
     * The ID of the TrainingSession.
     */
    #[ApiProperty(identifier: true)]
    public int $id;

    /**
     * The name of the TrainingSession.
     */
    public string $name;

    /**
     * The start date of the TrainingSession.
     */
    public \DateTimeInterface $startDate;
}
