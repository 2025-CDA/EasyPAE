<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OrganizationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: OrganizationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:organization']]
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['read:organization_collection']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['create:organization']]
        ),
        new Patch(
            denormalizationContext: ['groups' => ['update:organization']]
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:organization']]
        ),
        new Delete()
    ],
    order: ['createdAt' => 'DESC']
)]
class Organization
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
        'read:organization',
        'read:organization_collection',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:organization',
        'read:organization_collection',
        'create:organization',
        'update:organization'
    ])]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:organization',
        'read:organization_collection',
        'create:organization',
        'update:organization'
    ])]
    private ?string $name = null;

    /**
     * @var Collection<int, OrganizationMember>
     */
    #[ORM\OneToMany(targetEntity: OrganizationMember::class, mappedBy: 'organization')]
    #[Groups([
        'read:organization',
        'read:organization_collection',
        'create:organization',
        'update:organization'
    ])]
    private Collection $organizationMembers;

    /**
     * @var Collection<int, InfoForm>
     */
    #[ORM\OneToMany(targetEntity: InfoForm::class, mappedBy: 'organization')]
    #[Groups([
        'read:organization',
        'read:organization_collection',
        'create:organization',
        'update:organization'
    ])]
    private Collection $infoForms;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:organization',
        'read:organization_collection',
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:organization',
        'read:organization_collection',
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->organizationMembers = new ArrayCollection();
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

    /**
     * @return Collection<int, OrganizationMember>
     */
    public function getOrganizationMembers(): Collection
    {
        return $this->organizationMembers;
    }

    public function addOrganizationMember(OrganizationMember $organizationMember): static
    {
        if (!$this->organizationMembers->contains($organizationMember)) {
            $this->organizationMembers->add($organizationMember);
            $organizationMember->setOrganization($this);
        }

        return $this;
    }

    public function removeOrganizationMember(OrganizationMember $organizationMember): static
    {
        if ($this->organizationMembers->removeElement($organizationMember)) {
            // set the owning side to null (unless already changed)
            if ($organizationMember->getOrganization() === $this) {
                $organizationMember->setOrganization(null);
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
            $infoForm->setOrganization($this);
        }

        return $this;
    }

    public function removeInfoForm(InfoForm $infoForm): static
    {
        if ($this->infoForms->removeElement($infoForm)) {
            // set the owning side to null (unless already changed)
            if ($infoForm->getOrganization() === $this) {
                $infoForm->setOrganization(null);
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
