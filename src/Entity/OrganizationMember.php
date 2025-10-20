<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enum\OrganizationRole;
use App\Repository\OrganizationMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: OrganizationMemberRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:organization_member']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:organization_member_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:organization_member']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:organization_member']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:organization_member']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class OrganizationMember
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
        'read:organization_member',
        'read:organization_member_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(nullable: true, enumType: OrganizationRole::class)]
    #[Groups([
        'read:organization_member',
        'read:organization_member_collection',
        'create:organization_member',
        'update:organization_member'
    ])]
    private ?OrganizationRole $role = null;

    #[ORM\OneToOne(inversedBy: 'organizationMember', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:organization_member',
        'read:organization_member_collection',
        'create:organization_member',
        'update:organization_member'
    ])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'organizationMembers')]
    #[Groups([
        'read:organization_member',
        'read:organization_member_collection',
        'create:organization_member',
        'update:organization_member'
    ])]
    private ?Organization $organization = null;

    /**
     * @var Collection<int, TrainingSession>
     */
    #[ORM\ManyToMany(targetEntity: TrainingSession::class, inversedBy: 'organizationMembers')]
    #[Groups([
        'read:organization_member',
        'read:organization_member_collection',
        'create:organization_member',
        'update:organization_member'
    ])]
    private Collection $trainingSession;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:organization_member',
        'read:organization_member_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:organization_member',
        'read:organization_member_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->trainingSession = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?OrganizationRole
    {
        return $this->role;
    }

    public function setRole(?OrganizationRole $role): static
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
            $this->user->setOrganizationMember(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getOrganizationMember() !== $this) {
            $user->setOrganizationMember($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * @return Collection<int, TrainingSession>
     */
    public function getTrainingSession(): Collection
    {
        return $this->trainingSession;
    }

    public function addTrainingSession(TrainingSession $trainingSession): static
    {
        if (!$this->trainingSession->contains($trainingSession)) {
            $this->trainingSession->add($trainingSession);
        }

        return $this;
    }

    public function removeTrainingSession(TrainingSession $trainingSession): static
    {
        $this->trainingSession->removeElement($trainingSession);

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
