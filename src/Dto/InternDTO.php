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
            provider: InternProvider::class,
            name: 'intern_dashboard_detail',
            normalizationContext: ['groups' => ['read:intern_dashboard_detail']],
        ),
    ],
    processor: null
)]


class InternDTO
{
    #[ApiProperty(identifier: true)]

    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?int $id = null;

    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?string $status = null;

    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?\DateTimeInterface $internshipStartDate = null;

    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?\DateTimeInterface $internshipEndDate = null;

 
    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?string $firstName = null;

    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?string $lastName = null;

    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?string $email = null;

    #[Groups(['read:intern_dashboard', 'read:intern_dashboard_detail'])]
    public ?string $trainingName = null;

}
