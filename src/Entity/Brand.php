<?php

namespace App\Entity;

// =======================
// Repository + Doctrine + Symfony
// =======================
use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $motorization = null;

    #[ORM\Column]
    private ?int $numberPlace = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column]
    private ?bool $airConditioning = null;

    #[ORM\Column]
    private ?bool $luggageRack = null;

    #[ORM\Column]
    private ?bool $gps = null;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'brandVehicle')]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getMotorization(): ?string
    {
        return $this->motorization;
    }

    public function setMotorization(string $motorization): static
    {
        $this->motorization = $motorization;

        return $this;
    }

    public function getNumberPlace(): ?int
    {
        return $this->numberPlace;
    }

    public function setNumberPlace(int $numberPlace): static
    {
        $this->numberPlace = $numberPlace;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isAirConditioning(): ?bool
    {
        return $this->airConditioning;
    }

    public function setAirConditioning(bool $airConditioning): static
    {
        $this->airConditioning = $airConditioning;

        return $this;
    }

    public function isLuggageRack(): ?bool
    {
        return $this->luggageRack;
    }

    public function setLuggageRack(bool $luggageRack): static
    {
        $this->luggageRack = $luggageRack;

        return $this;
    }

    public function isGps(): ?bool
    {
        return $this->gps;
    }

    public function setGps(bool $gps): static
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setBrandVehicle($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getBrandVehicle() === $this) {
                $vehicle->setBrandVehicle(null);
            }
        }

        return $this;
    }
}
