<?php

namespace App\Entity;

use App\Repository\PreferencesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferencesRepository::class)]
class Preferences
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $animal = null;

    #[ORM\Column]
    private ?bool $smoker = null;

    #[ORM\Column]
    private ?bool $music = null;

    #[ORM\Column]
    private ?bool $disabled_equipment = null;

    #[ORM\Column]
    private ?bool $trailer = null;

    #[ORM\Column]
    private ?bool $usb_charger = null;

    #[ORM\Column]
    private ?bool $tablet = null;

    // 🔗 Relation OneToOne vers User
    #[ORM\OneToOne(inversedBy: 'preferences', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // ==========================
    // GETTERS / SETTERS
    // ==========================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAnimal(): ?bool
    {
        return $this->animal;
    }

    public function setAnimal(bool $animal): static
    {
        $this->animal = $animal;
        return $this;
    }

    public function isSmoker(): ?bool
    {
        return $this->smoker;
    }

    public function setSmoker(bool $smoker): static
    {
        $this->smoker = $smoker;
        return $this;
    }

    public function isMusic(): ?bool
    {
        return $this->music;
    }

    public function setMusic(bool $music): static
    {
        $this->music = $music;
        return $this;
    }

    public function isDisabledEquipment(): ?bool
    {
        return $this->disabled_equipment;
    }

    public function setDisabledEquipment(bool $disabled_equipment): static
    {
        $this->disabled_equipment = $disabled_equipment;
        return $this;
    }

    public function isTrailer(): ?bool
    {
        return $this->trailer;
    }

    public function setTrailer(bool $trailer): static
    {
        $this->trailer = $trailer;
        return $this;
    }

    public function isUsbCharger(): ?bool
    {
        return $this->usb_charger;
    }

    public function setUsbCharger(bool $usb_charger): static
    {
        $this->usb_charger = $usb_charger;
        return $this;
    }

    public function isTablet(): ?bool
    {
        return $this->tablet;
    }

    public function setTablet(bool $tablet): static
    {
        $this->tablet = $tablet;
        return $this;
    }

    // 🔗 USER RELATION
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
}
