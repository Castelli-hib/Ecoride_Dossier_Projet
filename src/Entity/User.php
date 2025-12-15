<?php

namespace App\Entity;

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

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\Email]
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

    // -------------------------
    // GETTERS / SETTERS
    // -------------------------
    public function getId(): ?int { return $this->id; }

    public function getUsername(): ?string { return $this->username; }
    public function setUsername(string $username): static { $this->username = $username; return $this; }

    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(string $firstname): static { $this->firstname = $firstname; return $this; }

    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(string $lastname): static { $this->lastname = $lastname; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function setPhoneNumber(?string $phoneNumber): static { $this->phoneNumber = $phoneNumber; return $this; }

    public function getStreet(): ?string { return $this->street; }
    public function setStreet(?string $street): static { $this->street = $street; return $this; }

    public function getAddressComplement(): ?string { return $this->addressComplement; }
    public function setAddressComplement(?string $addressComplement): static { $this->addressComplement = $addressComplement; return $this; }

    public function getPostalCode(): ?string { return $this->postalCode; }
    public function setPostalCode(?string $postalCode): static { $this->postalCode = $postalCode; return $this; }

    public function getCity(): ?string { return $this->city; }
    public function setCity(?string $city): static { $this->city = $city; return $this; }

    // Roles / Security
    public function getRoles(): array { return array_unique(array_merge($this->roles, ['ROLE_USER'])); }
    public function setRoles(array $roles): static { $this->roles = $roles; return $this; }
    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }
    public function getUserIdentifier(): string { return (string) $this->email; }
    public function eraseCredentials(): void {}

    // -------------------------
    // Credits
    // -------------------------
    public function getCredits(): Collection { return $this->credits; }
    public function addCredit(Credit $credit): static { if (!$this->credits->contains($credit)) { $this->credits->add($credit); $credit->setUser($this); } return $this; }
    public function removeCredit(Credit $credit): static { if ($this->credits->removeElement($credit) && $credit->getUser() === $this) { $credit->setUser(null); } return $this; }
    public function getBalance(): float { return array_sum(array_map(fn(Credit $c) => $c->getAmount(), $this->credits->toArray())); }

    // -------------------------
    // Avis
    // -------------------------
    public function getAvisReceived(): Collection { return $this->avisReceived; }
    public function getAvisGiven(): Collection { return $this->avisGiven; }
    public function getAverageRating(): float
    {
        $count = $this->avisReceived->count();
        if ($count === 0) return 0;
        $total = array_sum(array_map(fn(Avis $a) => $a->getNotation(), $this->avisReceived->toArray()));
        return round($total / $count, 1);
    }
    public function getAvisCount(): int { return $this->avisReceived->count(); }

    // -------------------------
    // Preferences
    // -------------------------
    public function getPreferences(): ?Preferences { return $this->preferences; }
    public function setPreferences(?Preferences $preferences): static
    {
        $this->preferences = $preferences;
        if ($preferences !== null && $preferences->getUser() !== $this) {
            $preferences->setUser($this);
        }
        return $this;
    }

    // -------------------------
    // Verification
    // -------------------------
    public function isVerified(): bool { return $this->isVerified; }
    public function setIsVerified(bool $isVerified): static { $this->isVerified = $isVerified; return $this; }

    // -------------------------
    // Helpers
    // -------------------------
    public function hasVehicle(): bool { return !$this->vehicles->isEmpty(); }
    public function hasReservation(): bool { return !$this->reservations->isEmpty(); }
    public function hasRoutes(): bool { return !$this->routes->isEmpty(); }
}
