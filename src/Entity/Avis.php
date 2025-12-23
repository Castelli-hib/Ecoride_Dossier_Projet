<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // ==========================
    // Champs métier
    // ==========================

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $comment = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(min: 1, max: 5)]
    private ?int $notation = null;

    // **Remplacement de la colonne createdAt**
    // Avant : #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    // On laisse Doctrine gérer la valeur via PrePersist (pas de DEFAULT dans la BDD)
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    // ==========================
    // Relations
    // ==========================

    #[ORM\ManyToOne(inversedBy: 'avisReceived')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userRated = null;

    #[ORM\ManyToOne(inversedBy: 'avisGiven')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userRater = null;

    #[ORM\ManyToOne(inversedBy: 'avis')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?Route $route = null;

    // ==========================
    // Lifecycle callbacks
    // ==========================

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        // Ligne remplacée / ajoutée : gestion automatique de createdAt
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }

        // Ligne existante pour le slug, inchangée
        if ($this->comment && $this->slug === null) {
            $slugger = new AsciiSlugger();
            $baseSlug = strtolower($slugger->slug(substr($this->comment, 0, 120)));
            $this->slug = $baseSlug . '-' . uniqid();
        }
    }

    // ==========================
    // Getters / Setters
    // ==========================

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function getNotation(): ?int
    {
        return $this->notation;
    }

    public function setNotation(int $notation): static
    {
        $this->notation = $notation;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getUserRated(): ?User
    {
        return $this->userRated;
    }

    public function setUserRated(User $userRated): static
    {
        $this->userRated = $userRated;
        return $this;
    }

    public function getUserRater(): ?User
    {
        return $this->userRater;
    }

    public function setUserRater(User $userRater): static
    {
        $this->userRater = $userRater;
        return $this;
    }

    public function getRoute(): ?Route
    {
        return $this->route;
    }

    public function setRoute(?Route $route): static
    {
        $this->route = $route;
        return $this;
    }
}
