<?php

namespace App\Entity;

use App\Enum\InfoFormStatus;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\InfoFormInternStatus;
use App\Enum\InfoFormCompanyStatus;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\InfoFormRepository;
use ApiPlatform\Metadata\GetCollection;
use App\Enum\InfoFormOrganizationStatus;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: InfoFormRepository::class)]
#[ORM\HasLifecycleCallbacks]
// #[ApiResource(
//     operations: [
//         new Get(
//             normalizationContext: ['groups' => ['read:info_form']]
//         ),
//         new GetCollection(
//             normalizationContext: ['groups' => ['read:info_form_collection']]
//         ),
//         new Post(
//             denormalizationContext: ['groups' => ['create:info_form']]
//         ),
//         new Patch(
//             denormalizationContext: ['groups' => ['update:info_form']]
//         ),
//         new Put(
//             denormalizationContext: ['groups' => ['update:info_form']]
//         ),
//         new Delete(),

//         new Get(
//             uriTemplate: '/info_forms/{id}/status',
//             normalizationContext: ['groups' => ['read:info_form-status']],
//             name: 'info_form-status'
//         ),
//         new Get(
//             uriTemplate: '/info_form/{id}/status/company',
//             normalizationContext: ['groups' => ['read:info_form-status-company']],
//             name: 'info_form-status-company'
//         ),

//         new Get(
//             uriTemplate: '/info_form/{id}/status/organization',
//             normalizationContext: ['groups' => ['read:info_form-status-organization']],
//             name: 'info_form-status-organization'
//         ),
//         new Get(
//             uriTemplate: '/info_form/{id}/status/intern',
//             normalizationContext: ['groups' => ['read:info_form-status-intern']],
//             name: 'info_form-status-intern'
//         ),

//     ],
//     order: ['createdAt' => 'DESC']
// )]
class InfoForm
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
        'read:info_form',
        'read:info_form_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(nullable: true, enumType: InfoFormStatus::class)]
    #[Groups([
        'read:info_form-status'
    ])]
    private ?InfoFormStatus $status = null;


    #[ORM\ManyToOne(inversedBy: 'infoForm')]
    #[Groups([
        'read:info_form',
        'read:info_form_collection',
        'create:info_form',
        'update:info_form'
    ])]
    private ?InternMember $internMember = null;

    #[ORM\OneToOne(inversedBy: 'infoForm', cascade: ['persist', 'remove'])]
    #[Groups([
        'read:info_form',
        'read:info_form_collection',
        'create:info_form',
        'update:info_form'
    ])]
    private ?InfoFormIntern $infoFormIntern = null;

    #[ORM\OneToOne(inversedBy: 'infoForm', cascade: ['persist', 'remove'])]
    #[Groups([
        'read:info_form',
        'read:info_form_collection',
        'create:info_form',
        'update:info_form'
    ])]
    private ?InfoFormOrganization $infoFormOrganization = null;

    #[ORM\OneToOne(inversedBy: 'infoForm', cascade: ['persist', 'remove'])]
    #[Groups([
        'read:info_form',
        'read:info_form_collection',
        'create:info_form',
        'update:info_form'
    ])]
    private ?InfoFormCompany $infoFormCompany = null;

    #[Groups([
        'read:info_form-status-company'
    ])]
    public function getStatusCompany(): ?string
    {
        return $this->getInfoFormCompany()?->getStatus()?->toString();
    }


    #[Groups([
        'read:info_form-status-intern'
    ])]
    public function getStatusIntern(): ?string
    {
        return $this->getInfoFormIntern()?->getStatus()?->toString();
    }


    #[Groups([
        'read:info_form-status-organization'
    ])]
    public function getStatusOrganization(): ?string
    {
        return $this->getInfoFormOrganization()?->getStatus()?->toString();
    }

    #[ORM\ManyToOne(inversedBy: 'infoForms')]
    #[Groups([
        'read:info_form',
        'read:info_form_collection',
        'create:info_form',
        'update:info_form'
    ])]
    private ?Organization $organization = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:info_form',
        'read:info_form_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:info_form',
        'read:info_form_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'infoForms')]
    private ?TrainingSession $trainingSession = null;

    /**
     * @var Collection<int, CompanyMember>
     */
    #[ORM\ManyToMany(targetEntity: CompanyMember::class, mappedBy: 'infoForms')]
    private Collection $companyMembers;

    public function __construct()
    {
        $this->companyMembers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?InfoFormStatus
    {
        return $this->status;
    }

    public function setStatus(?InfoFormStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getInternMember(): ?InternMember
    {
        return $this->internMember;
    }

    public function setInternMember(?InternMember $internMember): static
    {
        $this->internMember = $internMember;

        return $this;
    }

    public function getInfoFormIntern(): ?InfoFormIntern
    {
        return $this->infoFormIntern;
    }

    public function setInfoFormIntern(?InfoFormIntern $infoFormIntern): static
    {
        $this->infoFormIntern = $infoFormIntern;

        return $this;
    }

    public function getInfoFormOrganization(): ?InfoFormOrganization
    {
        return $this->infoFormOrganization;
    }

    public function setInfoFormOrganization(?InfoFormOrganization $infoFormOrganization): static
    {
        $this->infoFormOrganization = $infoFormOrganization;

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

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): static
    {
        $this->organization = $organization;

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

    public function getTrainingSession(): ?TrainingSession
    {
        return $this->trainingSession;
    }

    public function setTrainingSession(?TrainingSession $trainingSession): static
    {
        $this->trainingSession = $trainingSession;

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
            $companyMember->addInfoForm($this);
        }

        return $this;
    }

    public function removeCompanyMember(CompanyMember $companyMember): static
    {
        if ($this->companyMembers->removeElement($companyMember)) {
            $companyMember->removeInfoForm($this);
        }

        return $this;
    }
}
