<?php

namespace App\Entity;

// =======================
// Repository + Doctrine + Symfony
// =======================
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?User $user = null;

    // 🔧 MODIFIÉ : decimal Doctrine => string PHP (jamais float)
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $amount = '0.00';

    #[ORM\Column(length: 30)]
    private string $type = 'paiement';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    // 🔧 MODIFIÉ : decimal Doctrine => string PHP (jamais float)
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $balanceAfter = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    // 🔧 MODIFIÉ : retourne string (decimal Doctrine)
    public function getAmount(): string
    {
        return $this->amount;
    }

    // 🔧 MODIFIÉ : accepte string (ex: "12.50")
    public function setAmount(string $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    // 🔧 MODIFIÉ : retourne string|null (decimal Doctrine)
    public function getBalanceAfter(): ?string
    {
        return $this->balanceAfter;
    }

    // 🔧 MODIFIÉ : accepte string|null
    public function setBalanceAfter(?string $balanceAfter): static
    {
        $this->balanceAfter = $balanceAfter;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
