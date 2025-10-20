<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:company']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:company_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:company']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:company']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:company']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class Company
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
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection',
        'create:company',
        'update:company'
    ])]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection',
        'create:company',
        'update:company'
    ])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection',
        'create:company',
        'update:company'
    ])]
    private ?string $phoneNumber = null;

    /**
     * @var Collection<int, CompanyMember>
     */
    #[ORM\OneToMany(targetEntity: CompanyMember::class, mappedBy: 'company')]
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection',
        'create:company',
        'update:company',
    ])]
    private Collection $companyMembers;

    /**
     * @var Collection<int, InfoForm>
     */
    #[ORM\OneToMany(targetEntity: InfoForm::class, mappedBy: 'company')]
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection',
        'create:company',
        'update:company'
    ])]
    private Collection $infoForms;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company',
        'read:company_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->companyMembers = new ArrayCollection();
        $this->infoForms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, CompanyMember>
     */
    public function getCompanyMembers(): Collection
    {
        return $this->companyMembers;
    }

    public function addCompanyMember(CompanyMember $companyMember): static
    {
        if (!$this->companyMembers->contains($companyMember)) {
            $this->companyMembers->add($companyMember);
            $companyMember->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyMember(CompanyMember $companyMember): static
    {
        if ($this->companyMembers->removeElement($companyMember)) {
            // set the owning side to null (unless already changed)
            if ($companyMember->getCompany() === $this) {
                $companyMember->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InfoForm>
     */
    public function getInfoForms(): Collection
    {
        return $this->infoForms;
    }

    public function addInfoForm(InfoForm $infoForm): static
    {
        if (!$this->infoForms->contains($infoForm)) {
            $this->infoForms->add($infoForm);
            $infoForm->setCompany($this);
        }

        return $this;
    }

    public function removeInfoForm(InfoForm $infoForm): static
    {
        if ($this->infoForms->removeElement($infoForm)) {
            // set the owning side to null (unless already changed)
            if ($infoForm->getCompany() === $this) {
                $infoForm->setCompany(null);
            }
        }

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
