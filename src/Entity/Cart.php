<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CartItem;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: CartRepository::class)]
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
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le statut est obligatoire.")]
    #[Assert\Choice(
        choices: ['pending', 'validated', 'cancelled'],
        message: "Le statut doit être 'pending', 'validated' ou 'cancelled'."
    )]
    private ?string $status = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull(message: "La date de création est obligatoire.")]
    #[Assert\DateTime(message: "La date de création doit être une date valide.")]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Assert\DateTime(message: "La date de validation doit être une date valide.")]
    private ?\DateTimeInterface $validatedAt = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartItem::class, cascade: ['persist', 'remove'])]
    private Collection $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->status = 'pending';
    }

    // Getters / Setters

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validatedAt;
    }

    public function setValidatedAt(?\DateTimeInterface $validatedAt): static
    {
        $this->validatedAt = $validatedAt;

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
            $cartItem->setCart($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }

        return $this;
    }
}
