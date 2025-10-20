<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enum\WeekDay;
use App\Enum\WorkLocation;
use App\Repository\InfoFormCompanyCalendarRowRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: InfoFormCompanyCalendarRowRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:info_form_company_calendar_row']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:info_form_company_calendar_row_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:info_form_company_calendar_row']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:info_form_company_calendar_row']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:info_form_company_calendar_row']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class InfoFormCompanyCalendarRow
{
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        // Set the createdAt and updatedAt values on initial creation
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        // Set the updatedAt value on every update
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(nullable: true, enumType: WeekDay::class)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection',
        'create:info_form_company_calendar_row',
        'update:info_form_company_calendar_row'
    ])]
    private ?WeekDay $day = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection',
        'create:info_form_company_calendar_row',
        'update:info_form_company_calendar_row'
    ])]
    private ?\DateTimeImmutable $startMorning = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection',
        'create:info_form_company_calendar_row',
        'update:info_form_company_calendar_row'
    ])]
    private ?\DateTimeImmutable $endMorning = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection',
        'create:info_form_company_calendar_row',
        'update:info_form_company_calendar_row'
    ])]
    private ?\DateTimeImmutable $startAfternoon = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection',
        'create:info_form_company_calendar_row',
        'update:info_form_company_calendar_row'
    ])]
    private ?\DateTimeImmutable $endAfternoon = null;

    #[ORM\Column(nullable: true, enumType: WorkLocation::class)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection',
        'create:info_form_company_calendar_row',
        'update:info_form_company_calendar_row'
    ])]
    private ?WorkLocation $workLocation = null;

    #[ORM\ManyToOne(inversedBy: 'infoFormCompanyCalendarRow')]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection',
        'create:info_form_company_calendar_row',
        'update:info_form_company_calendar_row'
    ])]
    private ?InfoFormCompany $infoFormCompany = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:info_form_company_calendar_row',
        'read:info_form_company_calendar_row_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?WeekDay
    {
        return $this->day;
    }

    public function setDay(?WeekDay $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getStartMorning(): ?\DateTimeImmutable
    {
        return $this->startMorning;
    }

    public function setStartMorning(?\DateTimeImmutable $startMorning): static
    {
        $this->startMorning = $startMorning;

        return $this;
    }

    public function getEndMorning(): ?\DateTimeImmutable
    {
        return $this->endMorning;
    }

    public function setEndMorning(?\DateTimeImmutable $endMorning): static
    {
        $this->endMorning = $endMorning;

        return $this;
    }

    public function getStartAfternoon(): ?\DateTimeImmutable
    {
        return $this->startAfternoon;
    }

    public function setStartAfternoon(?\DateTimeImmutable $startAfternoon): static
    {
        $this->startAfternoon = $startAfternoon;

        return $this;
    }

    public function getEndAfternoon(): ?\DateTimeImmutable
    {
        return $this->endAfternoon;
    }

    public function setEndAfternoon(?\DateTimeImmutable $endAfternoon): static
    {
        $this->endAfternoon = $endAfternoon;

        return $this;
    }

    public function getWorkLocation(): ?WorkLocation
    {
        return $this->workLocation;
    }

    public function setWorkLocation(?WorkLocation $workLocation): static
    {
        $this->workLocation = $workLocation;

        return $this;
    }

    public function getInfoFormCompany(): ?InfoFormCompany
    {
        return $this->infoFormCompany;
    }

    public function setInfoFormCompany(?InfoFormCompany $infoFormCompany): static
    {
        $this->infoFormCompany = $infoFormCompany;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
