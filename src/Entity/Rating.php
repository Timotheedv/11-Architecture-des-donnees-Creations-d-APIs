<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),          
        new Patch(),         
        new Delete(),  
    ]
)]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le score est obligatoire.")]
    #[Assert\Range(
        min: 1,
        max: 5,
        notInRangeMessage: "Le score doit être entre {{ min }} et {{ max }}.",
    )]
    private ?int $score = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull(message: "La date de création est obligatoire.")]
    #[Assert\DateTime(message: "La date doit être une date valide.")]
    private ?\DateTimeInterface $createdAt = null;

    // Getters / Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

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
