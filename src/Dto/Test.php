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
        new Get(
            uriTemplate: '/test/{id}',
            uriVariables: [
                'id' => new Link(fromClass: self::class, identifiers: ['id']),
//                'sessionId' => new Link(fromClass: self::class, identifiers: ['sessionId'])
            ]
        ),
        new GetCollection(
            uriTemplate: '/tests'
        )
    ],
    // Tell API Platform to use our custom provider for this resource
    provider: TestProvider::class,
    // We don't have a processor because this is a read-only resource
    processor: null
)]
class Test
{
    #[ApiProperty(identifier: true)]
    public int $id;

    public string $userFullName;

}
