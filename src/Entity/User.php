<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\User\CreateUserController;
use App\Controller\User\UpdateUserController;
use App\Enum\UserRole;
use App\Repository\UserRepository;

//use App\State\UserStateProcessor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['read:user']]
        ),
        new GetCollection(
            paginationItemsPerPage: 10,
            paginationMaximumItemsPerPage: 10,
            paginationClientItemsPerPage: true,
            normalizationContext: ['groups' => ['read:user_collection']]
        ),
        new Post(
            controller: CreateUserController::class,
            denormalizationContext: ['groups' => ['create:user']],
        // When using a custom controller that handles persistence,
        // you should disable API Platform's default writer.
            write: false
        ),
        new Patch(
            controller: UpdateUserController::class,
            denormalizationContext: ['groups' => ['update:user']],
        // Also disable the writer here for the same reason.
            write: false
        ),
        new Put(
            denormalizationContext: ['groups' => ['update:user']]
        ),
        new Delete()
    ],
    order: ['id' => 'ASC']
)]
#[ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'exact',
        'email' => 'partial',
        'firstName' => 'partial',
        'lastName' => 'partial',
        'login' => 'partial'
    ]
)]
#[ApiFilter(OrderFilter::class, properties: ['id', 'createdAt', 'updatedAt'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt', 'updatedAt'])]
//#[ApiFilter(BooleanFilter::class, properties: ['isTrue'])]
//#[ApiFilter(RangeFilter::class, properties: ['price'])]
#[ApiFilter(ExistsFilter::class, properties: ['firstName', 'lastName', 'login', 'password'])]
//class User implements PasswordAuthenticatedUserInterface
class User implements UserInterface, PasswordAuthenticatedUserInterface
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

    /**
     * 4. This is the COMPATIBILITY method for Symfony Security.
     * It satisfies the UserInterface contract.
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = ['ROLE_USER']; // Always grant the basic role.

        // If a specific role is set, add its string value to the array.
        if ($this->role !== null) {
            $roles[] = $this->role->value;
        }

        return array_unique($roles);
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:user',
        'read:user_collection'
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups([
        'read:user',
        'read:user_collection',
        'create:user',
        'update:user'
    ])]
    private ?string $email = null;

//    /**
//     * @var list<string> The user roles
//     */
//    #[ORM\Column]
//    #[Groups([
//        'read:user',
//        'read:user_collection',
//        'create:user',
//        'update:user'
//    ])]
//    private array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[ORM\Column]
    #[Groups([
        'read:user',
        'read:user_collection'
    ])]
    private ?string $password = null;


    /**
     * @var string|null A temporary property to hold the plain password.
     */
    #[Groups([
        'create:user',
        'update:user'
    ])]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:user',
        'read:user_collection',
        'create:user',
        'update:user'
    ])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:user',
        'read:user_collection',
        'create:user',
        'update:user'
    ])]
    private ?string $lastName = null;

    #[Groups([
        'read:user',
        'read:user_collection'
    ])]
    public function getFullName(): ?string
    {
        return $this->lastName . ' ' . $this->firstName;
    }


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([
        'read:user',
        'read:user_collection',
        'create:user',
        'update:user'
    ])]
    private ?string $login = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: CompanyMember::class)]
    #[MaxDepth(1)]
    #[Groups([
        'read:user',
        'read:user_collection',
        'create:user',
        'update:user'
    ])]
    private ?CompanyMember $companyMember = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: OrganizationMember::class)]
    #[MaxDepth(1)]
    #[Groups([
        'read:user',
        'read:user_collection',
        'create:user',
        'update:user'
    ])]
    private ?OrganizationMember $organizationMember = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: InternMember::class)]
    #[MaxDepth(1)]
    #[Groups([
        'read:user',
        'read:user_collection',
        'create:user',
        'update:user'
    ])]
    private ?InternMember $internMember = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:user',
        'read:user_collection'
    ])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'read:user',
        'read:user_collection'
    ])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true, enumType: UserRole::class)]
    private ?UserRole $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

//    /**
//     * @see UserInterface
//     */
//    public function getRoles(): array
//    {
//        $roles = $this->roles;
//        // guarantee every user at least has ROLE_USER
//        $roles[] = 'ROLE_USER';
//
//        return array_unique($roles);
//    }
//
//    /**
//     * @param list<string> $roles
//     */
//    public function setRoles(array $roles): static
//    {
//        $this->roles = $roles;
//
//        return $this;
//    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        // If a plain password is set, it means the user is being modified.
        // We must update a persisted field to trigger the preUpdate event.
        if ($plainPassword !== null) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array)$this;
        $data["\0" . self::class . "\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getCompanyMember(): ?CompanyMember
    {
        return $this->companyMember;
    }

    public function setCompanyMember(?CompanyMember $companyMember): static
    {
        $this->companyMember = $companyMember;

        return $this;
    }

    public function getOrganizationMember(): ?OrganizationMember
    {
        return $this->organizationMember;
    }

    public function setOrganizationMember(?OrganizationMember $organizationMember): static
    {
        $this->organizationMember = $organizationMember;

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

    public function getRole(): ?UserRole
    {
        return $this->role;
    }

    public function setRole(?UserRole $role): static
    {
        $this->role = $role;

        return $this;
    }
}
