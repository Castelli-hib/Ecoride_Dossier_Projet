<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Avis;
use App\Entity\Credit;
use App\Entity\Reservation;
use App\Entity\Vehicle;
use App\Entity\Route;
use App\Entity\Preferences;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 3, max: 50)]
    private ?string $username = null;

    // -------------------------
    // Champs exposés dans route:read
    // -------------------------
    #[ORM\Column(length: 50)]
    #[Groups(['route:read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[Groups(['route:read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\Email]
    #[Groups(['route:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $street = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $addressComplement = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $resetToken = null;

    // -------------------------
    // Relations
    // -------------------------
    #[ORM\OneToMany(mappedBy: 'userVehicle', targetEntity: Vehicle::class, cascade: ['persist', 'remove'])]
    private Collection $vehicles;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Route::class, cascade: ['persist', 'remove'])]
    private Collection $routes;

    #[ORM\OneToMany(mappedBy: 'passager', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Credit::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $credits;

    #[ORM\OneToMany(mappedBy: 'userRated', targetEntity: Avis::class, cascade: ['remove'])]
    private Collection $avisReceived;

    #[ORM\OneToMany(mappedBy: 'userRater', targetEntity: Avis::class, cascade: ['remove'])]
    private Collection $avisGiven;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Preferences::class, cascade: ['persist', 'remove'])]
    private ?Preferences $preferences = null;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->routes = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->credits = new ArrayCollection();
        $this->avisReceived = new ArrayCollection();
        $this->avisGiven = new ArrayCollection();
    }

    // =========================
    // GETTERS / SETTERS
    // =========================

    public function getId(): ?int
    {
        return $this->id;
    }

    // -------------------------
    // User info exposée dans route:read
    // -------------------------
    #[Groups(['route:read'])]
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    #[Groups(['route:read'])]
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    #[Groups(['route:read'])]
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    // -------------------------
    // Autres champs (non exposés)
    // -------------------------
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setUsername(string $username): static
    {
        $this->username = $username;
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

    public function getStreet(): ?string
    {
        return $this->street;
    }
    public function setStreet(?string $street): static
    {
        $this->street = $street;
        return $this;
    }

    public function getAddressComplement(): ?string
    {
        return $this->addressComplement;
    }
    public function setAddressComplement(?string $addressComplement): static
    {
        $this->addressComplement = $addressComplement;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }
    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(?string $city): static
    {
        $this->city = $city;
        return $this;
    }

    // -------------------------
    // Roles / Password / Security
    // -------------------------
    public function getRoles(): array
    {
        return array_unique(array_merge($this->roles, ['ROLE_USER']));
    }
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    public function eraseCredentials(): void {}
    // -------------------------
    // Email verification
    // -------------------------
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
