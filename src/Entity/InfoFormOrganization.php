<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enum\InfoFormOrganizationStatus;
use App\Repository\InfoFormOrganizationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: InfoFormOrganizationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:info_form_organization']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:info_form_organization_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:info_form_organization']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:info_form_organization']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:info_form_organization']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class InfoFormOrganization
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
    #[Groups(['read:info_form_organization', 'read:info_form_organization_collection'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Groups([
        'read:info_form_organization',
        'read:info_form_organization_collection',
        'create:info_form_organization',
        'update:info_form_organization'
    ])]
    private ?\DateTimeImmutable $validationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:info_form_organization',
        'read:info_form_organization_collection',
        'create:info_form_organization',
        'update:info_form_organization'
    ])]
    private ?string $signature = null;

    #[ORM\OneToOne(mappedBy: 'infoFormOrganization', cascade: ['persist', 'remove'])]
    #[Groups([
        'read:info_form_organization',
        'read:info_form_organization_collection',
        'create:info_form_organization',
        'update:info_form_organization'
    ])]
    private ?InfoForm $infoForm = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:info_form_organization', 'read:info_form_organization_collection'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:info_form_organization', 'read:info_form_organization_collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true, enumType: InfoFormOrganizationStatus::class)]
    private ?InfoFormOrganizationStatus $status = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValidationDate(): ?\DateTimeImmutable
    {
        return $this->validationDate;
    }

    public function setValidationDate(?\DateTimeImmutable $validationDate): static
    {
        $this->validationDate = $validationDate;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): static
    {
        $this->signature = $signature;

        return $this;
    }

    public function getInfoForm(): ?InfoForm
    {
        return $this->infoForm;
    }

    public function setInfoForm(?InfoForm $infoForm): static
    {
        // unset the owning side of the relation if necessary
        if ($infoForm === null && $this->infoForm !== null) {
            $this->infoForm->setInfoFormOrganization(null);
        }

        // set the owning side of the relation if necessary
        if ($infoForm !== null && $infoForm->getInfoFormOrganization() !== $this) {
            $infoForm->setInfoFormOrganization($this);
        }

        $this->infoForm = $infoForm;

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

    public function getStatus(): ?InfoFormOrganizationStatus
    {
        return $this->status;
    }

    public function setStatus(?InfoFormOrganizationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

}
