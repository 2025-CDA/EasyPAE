<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enum\CompanyRole;
use App\Repository\CompanyMemberRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: CompanyMemberRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:company_member']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:company_member_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:company_member']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:company_member']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:company_member']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class CompanyMember
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
        'read:company_member',
        'read:company_member_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(nullable: true, enumType: CompanyRole::class)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company_member',
        'read:company_member_collection',
        'create:company_member',
        'update:company_member'
    ])]
    private ?CompanyRole $role = null;

    #[ORM\OneToOne(inversedBy: 'companyMember', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company_member',
        'read:company_member_collection',
        'create:company_member',
        'update:company_member'
    ])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'companyMembers')]
    #[MaxDepth(1)]
    #[Groups([
        'read:company_member',
        'read:company_member_collection',
        'create:company_member',
        'update:company_member'
    ])]
    private ?Company $company = null;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company_member',
        'read:company_member_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:company_member',
        'read:company_member_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?CompanyRole
    {
        return $this->role;
    }

    public function setRole(?CompanyRole $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setCompanyMember(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getCompanyMember() !== $this) {
            $user->setCompanyMember($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
