<?php

namespace App\Entity;


// =======================
// Repository + Doctrine + Symfony
// =======================
use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Commentaire de l'avis
    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    // Note donnée
    #[ORM\Column(type: 'integer')]
    private ?int $notation = null;

    // Slug pour URL friendly
    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    // ------------------------------
    // Relations avec les utilisateurs
    // ------------------------------
    #[ORM\ManyToOne(inversedBy: 'avisReceived', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userRated = null; // utilisateur noté

    #[ORM\ManyToOne(inversedBy: 'avisGiven', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userRater = null; // utilisateur qui note

    // ------------------------------
    // Relation avec la route
    // ------------------------------
    #[ORM\ManyToOne(inversedBy: 'avis', targetEntity: Route::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: "CASCADE")]
    private ?Route $route = null;

    // ------------------------------
    // Lifecycle callbacks
    // ------------------------------
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generateSlug(): void
    {
        if ($this->comment) {
            $slugger = new AsciiSlugger();
            $baseSlug = strtolower($slugger->slug(substr($this->comment, 0, 120)));
            $this->slug = $baseSlug . '-' . uniqid();
        }
    }

    // ==========================
    // GETTERS / SETTERS
    // ==========================
    public function getId(): ?int { return $this->id; }

    public function getComment(): ?string { return $this->comment; }
    public function setComment(string $comment): static { $this->comment = $comment; return $this; }

    public function getNotation(): ?int { return $this->notation; }
    public function setNotation(int $notation): static { $this->notation = $notation; return $this; }

    public function getSlug(): ?string { return $this->slug; }
    public function setSlug(string $slug): static { $this->slug = $slug; return $this; }

    public function getUserRated(): ?User { return $this->userRated; }
    public function setUserRated(?User $userRated): static { $this->userRated = $userRated; return $this; }

    public function getUserRater(): ?User { return $this->userRater; }
    public function setUserRater(?User $userRater): static { $this->userRater = $userRater; return $this; }

    public function getRoute(): ?Route { return $this->route; }
    public function setRoute(?Route $route): static { $this->route = $route; return $this; }
}
