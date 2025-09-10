<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'Il y a déjà un compte avec cet e-mail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(nullable: true)]
    private ?int $phone_number = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(length: 50)]
    private ?string $role = null;

    #[ORM\Column(options: ["default" => 0])]
    private int $credit = 0;

    #[ORM\Column(options: ["default" => false])]
    private bool $isVerified = false;

    #[ORM\ManyToOne(inversedBy: 'userAvis')]
    private ?Avis $avis = null;

    #[ORM\ManyToOne(inversedBy: 'userVehicle')]
    private ?Vehicle $vehicle = null;

    #[ORM\ManyToMany(targetEntity: Preferences::class, mappedBy: 'user_id')]
    private Collection $preferences;

    #[ORM\ManyToMany(targetEntity: Route::class, mappedBy: 'userRoute')]
    private Collection $routes;

    public function __construct()
    {
        $this->preferences = new ArrayCollection();
        $this->routes = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function getUserIdentifier(): string { return (string) $this->email; }
    public function getRoles(): array { $roles = $this->roles; $roles[] = 'ROLE_USER'; return array_unique($roles); }
    public function setRoles(array $roles): static { $this->roles = $roles; return $this; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }

    public function eraseCredentials(): void {}

    public function getUsername(): ?string { return $this->username; }
    public function setUsername(string $username): static { $this->username = $username; return $this; }

    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(string $firstname): static { $this->firstname = $firstname; return $this; }

    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(string $lastname): static { $this->lastname = $lastname; return $this; }

    public function getPhoneNumber(): ?int { return $this->phone_number; }
    public function setPhoneNumber(?int $phone_number): static { $this->phone_number = $phone_number; return $this; }

    public function getAdress(): ?string { return $this->adress; }
    public function setAdress(string $adress): static { $this->adress = $adress; return $this; }

    public function getRole(): ?string { return $this->role; }
    public function setRole(string $role): static { $this->role = $role; return $this; }

    public function getCredit(): int { return $this->credit; }
    public function setCredit(int $credit): static { $this->credit = $credit; return $this; }

    public function isVerified(): bool { return $this->isVerified; }
    public function setIsVerified(bool $isVerified): static { $this->isVerified = $isVerified; return $this; }

    public function getAvis(): ?Avis { return $this->avis; }
    public function setAvis(?Avis $avis): static { $this->avis = $avis; return $this; }

    public function getVehicle(): ?Vehicle { return $this->vehicle; }
    public function setVehicle(?Vehicle $vehicle): static { $this->vehicle = $vehicle; return $this; }

    public function getPreferences(): Collection { return $this->preferences; }
    public function addPreference(Preferences $preference): static { 
        if (!$this->preferences->contains($preference)) { 
            $this->preferences->add($preference); 
            $preference->addUserId($this); 
        } 
        return $this; 
    }
    public function removePreference(Preferences $preference): static { 
        if ($this->preferences->removeElement($preference)) { 
            $preference->removeUserId($this); 
        } 
        return $this; 
    }

    public function getRoutes(): Collection { return $this->routes; }
    public function addRoute(Route $route): static { 
        if (!$this->routes->contains($route)) { 
            $this->routes->add($route); 
            $route->addUserRoute($this); 
        } 
        return $this; 
    }
    public function removeRoute(Route $route): static { 
        if ($this->routes->removeElement($route)) { 
            $route->removeUserRoute($this); 
        } 
        return $this; 
    }
}
