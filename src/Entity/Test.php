<?php
// src/Entity/Test.php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\State\OfferNumberProvider;
// --- 1. Import the necessary OpenAPI model classes ---
use ApiPlatform\OpenApi\Model;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/offer_number',
            openapi: new Model\Operation(
                responses: [
                    '200' => new Model\Response(
                        description: 'Successful response',
                        content: new \ArrayObject([
//                            'application/json' => new Model\MediaType(
//                                schema: new Model\Schema(
//                                    type: 'object',
//                                    properties: [
//                                        'offerNumber' => new Model\Schema(
//                                            type: 'string',
//                                            example: 'OFF-2024-00123'
//                                        )
//                                    ]
//                                )
//                            )
                        ])
                    )
                ],
                summary: 'Get the offer number',
                description: 'Retrieve the current offer number from the system.'
            ),
            normalizationContext: ['groups' => ['read:test']],
            name: 'getOfferNumber',

            // --- 2. Rebuild the openapi configuration as an object ---
            provider: OfferNumberProvider::class
        ),
    ]
)]
class Test
{
    #[Groups(['read:test'])]
    public string $offerNumber;
}
