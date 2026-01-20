<?php

namespace App\Entity;

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

    #[ORM\Column]
    private bool $allowAnimal = false;

    #[ORM\Column]
    private bool $allowSmoker = false;

    #[ORM\Column]
    private bool $allowMusic = true;

    #[ORM\Column]
    private bool $allowDisabledEquipment = false;


    // // Nouveau champ : nombre de places maximum
    // #[ORM\Column]
    // private ?int $maxSeats = 4;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    // =======================
    // GETTERS / SETTERS
    // =======================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureTown(): ?string
    {
        return $this->departureTown;
    }
    public function setDepartureTown(string $departureTown): static
    {
        $this->departureTown = $departureTown;
        return $this;
    }

    public function getArrivalTown(): ?string
    {
        return $this->arrivalTown;
    }
    public function setArrivalTown(string $arrivalTown): static
    {
        $this->arrivalTown = $arrivalTown;
        return $this;
    }

    public function getDepartureDay(): ?\DateTimeInterface
    {
        return $this->departureDay;
    }
    public function setDepartureDay(\DateTimeInterface $departureDay): static
    {
        $this->departureDay = $departureDay;
        return $this;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }
    public function setDepartureTime(\DateTimeInterface $departureTime): static
    {
        $this->departureTime = $departureTime;
        return $this;
    }

    public function getTravelTime(): ?int
    {
        return $this->travelTime;
    }
    public function setTravelTime(int $travelTime): static
    {
        $this->travelTime = $travelTime;
        return $this;
    }

    public function isCorrespondance(): bool
    {
        return $this->correspondance;
    }
    public function setCorrespondance(bool $correspondance): static
    {
        $this->correspondance = $correspondance;
        return $this;
    }

    public function getCorrespondanceDetail(): ?string
    {
        return $this->correspondanceDetail;
    }
    public function setCorrespondanceDetail(?string $correspondanceDetail): static
    {
        $this->correspondanceDetail = $correspondanceDetail;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getAvis(): Collection
    {
        return $this->avis;
    }
    public function addAvis(Avis $avis): static
    {
        if (!$this->avis->contains($avis)) {
            $this->avis->add($avis);
            $avis->setRoute($this);
        }
        return $this;
    }
    public function removeAvis(Avis $avis): static
    {
        if ($this->avis->removeElement($avis)) {
            $avis->setRoute(null);
        }
        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }
    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRoute($this);
        }
        return $this;
    }
    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->setRoute(null);
        }
        return $this;
    }

    public function allowsAnimal(): bool
    {
        return $this->allowAnimal;
    }

    public function setAllowAnimal(bool $allowAnimal): static
    {
        $this->allowAnimal = $allowAnimal;
        return $this;
    }

    public function allowsSmoker(): bool
    {
        return $this->allowSmoker;
    }

    public function setAllowSmoker(bool $allowSmoker): static
    {
        $this->allowSmoker = $allowSmoker;
        return $this;
    }

    public function allowsMusic(): bool
    {
        return $this->allowMusic;
    }

    public function setAllowMusic(bool $allowMusic): static
    {
        $this->allowMusic = $allowMusic;
        return $this;
    }

    public function allowsDisabledEquipment(): bool
    {
        return $this->allowDisabledEquipment;
    }

    public function setAllowDisabledEquipment(bool $allowDisabledEquipment): static
    {
        $this->allowDisabledEquipment = $allowDisabledEquipment;
        return $this;
    }


    // =======================
    // LOGIQUE METIER – PLACES
    // =======================

    // public function getMaxSeats(): int { return $this->maxSeats ?? 4; }
    // public function setMaxSeats(int $maxSeats): static { $this->maxSeats = $maxSeats; return $this; }

    // public function getReservedSeats(): int { return $this->reservations->count(); }

    // public function getAvailableSeats(): int
    // {
    //     return max(0, $this->getMaxSeats() - $this->getReservedSeats());
    // }

    // public function hasAvailableSeats(): bool
    // {
    //     return $this->getAvailableSeats() > 0;
    // }
}
