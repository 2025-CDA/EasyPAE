<?php

namespace App\Dto;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Entity\Organization;
use App\State\OrganizationProvider;

#[ApiResource(
//    operations: [
//        new GetCollection(
//            uriTemplate: '/organization/{organizationId}/sessions',
//            uriVariables: [
//                'organizationId' => new Link(
//                    fromClass: Organization::class,
//                    identifiers: ['id']
//                )
//            ],
//            provider: OrganizationProvider::class,
//        )
//    ],
//    processor: null
)]
class InfoFormDTO
{


}
