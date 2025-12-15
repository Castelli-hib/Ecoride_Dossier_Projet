<?php

namespace App\Entity;

// =======================
// Entités liées
// =======================
use App\Entity\User;
use App\Entity\Route;

// =======================
// Repository + Doctrine + Symfony
// =======================
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateReservation = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isConfirmed = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $passager = null;

    #[ORM\ManyToOne(targetEntity: Route::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Route $route = null;

    // GETTERS / SETTERS
    public function getId(): ?int { return $this->id; }
    public function getDateReservation(): ?\DateTimeInterface { return $this->dateReservation; }
    public function setDateReservation(\DateTimeInterface $dateReservation): static { $this->dateReservation = $dateReservation; return $this; }

    public function isConfirmed(): bool { return $this->isConfirmed; }
    public function setIsConfirmed(bool $isConfirmed): static { $this->isConfirmed = $isConfirmed; return $this; }

    public function getPassager(): ?User { return $this->passager; }
    public function setPassager(?User $passager): static { $this->passager = $passager; return $this; }

    public function getRoute(): ?Route { return $this->route; }
    public function setRoute(?Route $route): static { $this->route = $route; return $this; }
}
