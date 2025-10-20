<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: TrainingRepository::class)]
#[ORM\HasLifecycleCallbacks]

#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:training']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:training_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:training']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:training']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:training']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class Training
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
        'read:training',
        'read:training_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:training',
        'read:training_collection',
        'create:training',
        'update:training',
    ])]
    private ?string $name = null;

    /**
     * @var Collection<int, TrainingSession>
     */
    #[ORM\OneToMany(targetEntity: TrainingSession::class, mappedBy: 'training')]
    #[MaxDepth(1)]
    #[Groups([
        'read:training',
        'read:training_collection',
        'create:training',
        'update:training'
    ])]
    private Collection $trainingSessions;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:training',
        'read:training_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[MaxDepth(1)]
    #[Groups([
        'read:training',
        'read:training_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->trainingSessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, TrainingSession>
     */
    public function getTrainingSessions(): Collection
    {
        return $this->trainingSessions;
    }

    public function addTrainingSession(TrainingSession $trainingSession): static
    {
        if (!$this->trainingSessions->contains($trainingSession)) {
            $this->trainingSessions->add($trainingSession);
            $trainingSession->setTraining($this);
        }

        return $this;
    }

    public function removeTrainingSession(TrainingSession $trainingSession): static
    {
        if ($this->trainingSessions->removeElement($trainingSession)) {
            // set the owning side to null (unless already changed)
            if ($trainingSession->getTraining() === $this) {
                $trainingSession->setTraining(null);
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
