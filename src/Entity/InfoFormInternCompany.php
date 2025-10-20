<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\InfoFormInternCompanyRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: InfoFormInternCompanyRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:info_form_intern_company']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:info_form_intern_company_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:info_form_intern_company']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:info_form_intern_company']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:info_form_intern_company']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class InfoFormInternCompany
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
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection',
        'create:info_form_intern_company',
        'update:info_form_intern_company'
    ])]
    private ?string $companyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection',
        'create:info_form_intern_company',
        'update:info_form_intern_company'
    ])]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection',
        'create:info_form_intern_company',
        'update:info_form_intern_company'
    ])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection',
        'create:info_form_intern_company',
        'update:info_form_intern_company'
    ])]
    private ?string $contactName = null;

    #[ORM\OneToOne(mappedBy: 'infoFormInternCompany', cascade: ['persist', 'remove'])]
    #[Groups([
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection',
        'create:info_form_intern_company',
        'update:info_form_intern_company'
    ])]
    private ?InfoFormIntern $infoFormIntern = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:info_form_intern_company',
        'read:info_form_intern_company_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $name): static
    {
        $this->companyName = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): static
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getInfoFormIntern(): ?InfoFormIntern
    {
        return $this->infoFormIntern;
    }

    public function setInfoFormIntern(?InfoFormIntern $infoFormIntern): static
    {
        // unset the owning side of the relation if necessary
        if ($infoFormIntern === null && $this->infoFormIntern !== null) {
            $this->infoFormIntern->setInfoFormInternCompany(null);
        }

        // set the owning side of the relation if necessary
        if ($infoFormIntern !== null && $infoFormIntern->getInfoFormInternCompany() !== $this) {
            $infoFormIntern->setInfoFormInternCompany($this);
        }

        $this->infoFormIntern = $infoFormIntern;

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
