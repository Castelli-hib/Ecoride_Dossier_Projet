<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $year = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $kilometer = null;

    #[ORM\Column]
    private ?bool $isActif = null;

    // 🔗 Relation ManyToOne vers User
    #[ORM\ManyToOne(inversedBy: 'vehicles', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userVehicle = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles', targetEntity: Brand::class)]
    private ?Brand $brandVehicle = null;

    // ==========================
    // GETTERS / SETTERS
    // ==========================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): static
    {
        $this->year = $year;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getKilometer(): ?int
    {
        return $this->kilometer;
    }

    public function setKilometer(int $kilometer): static
    {
        $this->kilometer = $kilometer;
        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(bool $isActif): static
    {
        $this->isActif = $isActif;
        return $this;
    }

    // 🔗 RELATION USER
    public function getUserVehicle(): ?User
    {
        return $this->userVehicle;
    }

    public function setUserVehicle(?User $userVehicle): static
    {
        $this->userVehicle = $userVehicle;
        return $this;
    }

    // 🔗 RELATION BRAND
    public function getBrandVehicle(): ?Brand
    {
        return $this->brandVehicle;
    }

    public function setBrandVehicle(?Brand $brandVehicle): static
    {
        $this->brandVehicle = $brandVehicle;
        return $this;
    }
}
