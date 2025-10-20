<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\InternMemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: InternMemberRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:intern_member']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:intern_member_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:intern_member']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:intern_member']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:intern_member']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class InternMember
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
        'read:intern_member',
        'read:intern_member_collection'
    ])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'internMember', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    #[Groups([
        'read:intern_member',
        'read:intern_member_collection',
        'create:intern_member',
        'update:intern_member'
    ])]
    private ?User $user = null;

    /**
     * @var Collection<int, TrainingSession>
     */
    #[ORM\ManyToMany(targetEntity: TrainingSession::class, inversedBy: 'internMembers')]
    #[MaxDepth(1)]
    #[Groups([
        'read:intern_member',
        'read:intern_member_collection',
        'create:intern_member',
        'update:intern_member'
    ])]
    private Collection $trainingSession;

    /**
     * @var Collection<int, InfoForm>
     */
    #[ORM\OneToMany(targetEntity: InfoForm::class, mappedBy: 'internMember')]
    #[MaxDepth(1)]
    #[Groups([
        'read:intern_member',
        'read:intern_member_collection',
        'create:intern_member',
        'update:intern_member'
    ])]
    private Collection $infoForm;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:intern_member',
        'read:intern_member_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:intern_member',
        'read:intern_member_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->trainingSession = new ArrayCollection();
        $this->infoForm = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setInternMember(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getInternMember() !== $this) {
            $user->setInternMember($this);
        }

        $this->user = $user;

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

    /**
     * @return Collection<int, InfoForm>
     */
    public function getInfoForm(): Collection
    {
        return $this->infoForm;
    }

    public function addInfoForm(InfoForm $infoForm): static
    {
        if (!$this->infoForm->contains($infoForm)) {
            $this->infoForm->add($infoForm);
            $infoForm->setInternMember($this);
        }

        return $this;
    }

    public function removeInfoForm(InfoForm $infoForm): static
    {
        if ($this->infoForm->removeElement($infoForm)) {
            // set the owning side to null (unless already changed)
            if ($infoForm->getInternMember() === $this) {
                $infoForm->setInternMember(null);
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
