<?php
// src/Model/SearchRide.php
namespace App\Model;

class SearchRide
{
    public ?string $departure = null;
    public ?string $arrival = null;
    public ?\DateTimeInterface $date = null;
    public ?int $passengers = null;
}
