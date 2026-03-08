<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\User;
use App\Entity\Avis;
use App\Entity\Reservation;
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
    #[Groups(['route:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['route:read'])]
    private ?string $departureTown = null;

    #[ORM\Column(length: 255)]
    #[Groups(['route:read'])]
    private ?string $arrivalTown = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['route:read'])]
    private ?\DateTimeInterface $departureDay = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['route:read'])]
    private ?\DateTimeInterface $departureTime = null;

    #[ORM\Column]
    #[Groups(['route:read'])]
    private ?int $travelTime = null;

    // ========================
    // Champs supplémentaires pour les options du trajet
    // ========================
    #[ORM\Column(type: 'boolean')]
    private bool $correspondance = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $correspondanceDetail = null;

    #[ORM\Column(type: 'boolean')]
    private bool $allowAnimal = false;

    #[ORM\Column(type: 'boolean')]
    private bool $allowSmoker = false;

    #[ORM\Column(type: 'boolean')]
    private bool $allowMusic = true;

    #[ORM\Column(type: 'boolean')]
    private bool $allowDisabledEquipment = false;

    // ========================
    // Relation avec l'utilisateur
    // ========================
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'routes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['route:read'])]
    private ?User $user = null;

    // ========================
    // Relations avec Avis et Reservations
    // ========================
    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Avis::class, cascade: ['persist', 'remove'])]
    private Collection $avis;

    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    // ========================
    // GETTERS / SETTERS
    // ========================
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

    // ========================
    // Correspondance
    // ========================
    public function isCorrespondance(): bool { return $this->correspondance; }
    public function setCorrespondance(bool $correspondance): static { $this->correspondance = $correspondance; return $this; }

    public function getCorrespondanceDetail(): ?string { return $this->correspondanceDetail; }
    public function setCorrespondanceDetail(?string $correspondanceDetail): static { $this->correspondanceDetail = $correspondanceDetail; return $this; }

    // ========================
    // Options
    // ========================
    public function allowsAnimal(): bool { return $this->allowAnimal; }
    public function setAllowAnimal(bool $allowAnimal): static { $this->allowAnimal = $allowAnimal; return $this; }

    public function allowsSmoker(): bool { return $this->allowSmoker; }
    public function setAllowSmoker(bool $allowSmoker): static { $this->allowSmoker = $allowSmoker; return $this; }

    public function allowsMusic(): bool { return $this->allowMusic; }
    public function setAllowMusic(bool $allowMusic): static { $this->allowMusic = $allowMusic; return $this; }

    public function allowsDisabledEquipment(): bool { return $this->allowDisabledEquipment; }
    public function setAllowDisabledEquipment(bool $allowDisabledEquipment): static { $this->allowDisabledEquipment = $allowDisabledEquipment; return $this; }

    // ========================
    // User
    // ========================
    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): static { $this->user = $user; return $this; }

    // ========================
    // Avis / Reservations
    // ========================
    public function getAvis(): Collection { return $this->avis; }
    public function addAvis(Avis $avis): static { 
        if (!$this->avis->contains($avis)) { $this->avis->add($avis); $avis->setRoute($this); } 
        return $this; 
    }
    public function removeAvis(Avis $avis): static { 
        if ($this->avis->removeElement($avis)) { $avis->setRoute(null); } 
        return $this; 
    }

    public function getReservations(): Collection { return $this->reservations; }
    public function addReservation(Reservation $reservation): static { 
        if (!$this->reservations->contains($reservation)) { $this->reservations->add($reservation); $reservation->setRoute($this); } 
        return $this; 
    }
    public function removeReservation(Reservation $reservation): static { 
        if ($this->reservations->removeElement($reservation)) { $reservation->setRoute(null); } 
        return $this; 
    }
}
