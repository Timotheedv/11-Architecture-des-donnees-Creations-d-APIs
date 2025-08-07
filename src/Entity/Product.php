<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
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
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 10,
        max: 1000,
        minMessage: "La description doit contenir au moins {{ limit }} caractères.",
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le prix est obligatoire.")]
    #[Assert\Positive(message: "Le prix doit être positif.")]
    private ?float $price = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Assert\Url(message: "L’URL de l’image n’est pas valide.")]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La disponibilité est obligatoire.")]
    #[Assert\Type(type: 'bool', message: "La disponibilité doit être un booléen.")]
    private ?bool $available = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CartItem::class, cascade: ['persist', 'remove'])]
    private Collection $cartItems;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Rating::class, cascade: ['persist', 'remove'])]
    private Collection $ratings;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

        return $this;
    }

    /**
     * @return Collection|CartItem[]
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): static
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems->add($cartItem);
            $cartItem->setProduct($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            if ($cartItem->getProduct() === $this) {
                $cartItem->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): static
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setProduct($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): static
    {
        if ($this->ratings->removeElement($rating)) {
            if ($rating->getProduct() === $this) {
                $rating->setProduct(null);
            }
        }

        return $this;
    }
}
