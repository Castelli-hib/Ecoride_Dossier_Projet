<?php

namespace App\Entity;

// =======================
// Entités liées
// =======================

use App\Entity\User;
use App\Entity\Avis;
use App\Entity\Reservation;


// =======================
// Repository + Doctrine + Symfony
// =======================
use App\Repository\RouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouteRepository::class)]
class Route
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $departureTown = null;

    #[ORM\Column(length: 255)]
    private ?string $arrivalTown = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $departureDay = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $departureTime = null;

    #[ORM\Column]
    private ?int $travelTime = null;

    #[ORM\Column]
    private ?bool $correspondance = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correspondanceDetail = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'routes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Avis::class, cascade: ['persist', 'remove'])]
    private Collection $avis;

    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    // GETTERS / SETTERS
    public function getId(): ?int { return $this->id; }
    public function getDepartureTown(): ?string { return $this->departureTown; }
    public function setDepartureTown(string $departureTown): static { $this->departureTown = $departureTown; return $this; }

    public function getArrivalTown(): ?string { return $this->arrivalTown; }
    public function setArrivalTown(string $arrivalTown): static { $this->arrivalTown = $arrivalTown; return $this; }

    public function getDepartureDay(): ?\DateTimeInterface { return $this->departureDay; }
    public function setDepartureDay(\DateTimeInterface $departureDay): static { $this->departureDay = $departureDay; return $this; }

    public function getDepartureTime(): ?\DateTimeInterface { return $this->departureTime; }
    public function setDepartureTime(\DateTimeInterface $departureTime): static { $this->departureTime = $departureTime; return $this; }

    public function getTravelTime(): ?int { return $this->travelTime; }
    public function setTravelTime(int $travelTime): static { $this->travelTime = $travelTime; return $this; }

    public function isCorrespondance(): bool { return $this->correspondance; }
    public function setCorrespondance(bool $correspondance): static { $this->correspondance = $correspondance; return $this; }

    public function getCorrespondanceDetail(): ?string { return $this->correspondanceDetail; }
    public function setCorrespondanceDetail(?string $correspondanceDetail): static { $this->correspondanceDetail = $correspondanceDetail; return $this; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }

    public function getAvis(): Collection { return $this->avis; }
    public function addAvis(Avis $avis): static { if (!$this->avis->contains($avis)) { $this->avis->add($avis); $avis->setRoute($this); } return $this; }
    public function removeAvis(Avis $avis): static { if ($this->avis->removeElement($avis)) { $avis->setRoute(null); } return $this; }

    public function getReservations(): Collection { return $this->reservations; }
    public function addReservation(Reservation $reservation): static { if (!$this->reservations->contains($reservation)) { $this->reservations->add($reservation); $reservation->setRoute($this); } return $this; }
    public function removeReservation(Reservation $reservation): static { if ($this->reservations->removeElement($reservation)) { $reservation->setRoute(null); } return $this; }
}
