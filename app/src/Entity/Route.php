<?php

namespace App\Entity;

use App\Repository\RouteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
    private ?\DateTime $departureDay = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $departureTime = null;

    #[ORM\Column]
    private ?int $travelTime = null;

    #[ORM\Column]
    private ?bool $correspondance = null;

    #[ORM\Column(length: 255)]
    private ?string $correspondanceDetail = null;

    // Chaque route appartient à un utilisateur (conducteur)
    #[ORM\ManyToOne(inversedBy: 'routes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Une route peut avoir plusieurs avis
    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Avis::class, cascade: ['persist', 'remove'])]
    private Collection $avis;

    // Une route peut avoir plusieurs réservations
    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    // ==========================
    // GETTERS / SETTERS
    // ==========================

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

    public function getDepartureDay(): ?\DateTime
    {
        return $this->departureDay;
    }

    public function setDepartureDay(\DateTime $departureDay): static
    {
        $this->departureDay = $departureDay;
        return $this;
    }

    public function getDepartureTime(): ?\DateTime
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTime $departureTime): static
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

    public function isCorrespondance(): ?bool
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

    public function setCorrespondanceDetail(string $correspondanceDetail): static
    {
        $this->correspondanceDetail = $correspondanceDetail;
        return $this;
    }

    //  USER
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    //  AVIS
    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(object $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            if (method_exists($avi, 'setRoute')) {
                $avi->setRoute($this);
            }
        }
        return $this;
    }

    public function removeAvi(object $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            if (method_exists($avi, 'setRoute')) {
                $avi->setRoute(null);
            }
        }
        return $this;
    }

    // RÉSERVATIONS
    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation($reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            if (is_object($reservation) && method_exists($reservation, 'setRoute')) {
                $reservation->setRoute($this);
            }
        }
        return $this;
    }

    public function removeReservation($reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            if (is_object($reservation) && method_exists($reservation, 'setRoute')) {
                $reservation->setRoute(null);
            }
        }
        return $this;
    }
}
