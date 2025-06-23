<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    normalizationContext: ['groups' => ['order_item:read']],
    denormalizationContext: ['groups' => ['order_item:write']]
)]
#[ORM\Entity]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['order_item:read'])]
    private UuidV7 $id;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['order_item:read', 'order_item:write'])]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['order_item:read', 'order_item:write'])]
    private ?Product $product = null;

    #[ORM\Column]
    #[Groups(['order_item:read', 'order_item:write'])]
    private float $priceProduct;

    #[ORM\Column(length: 255)]
    #[Groups(['order_item:read', 'order_item:write'])]
    private string $productName;

    #[ORM\Column]
    #[Groups(['order_item:read', 'order_item:write'])]
    private int $quantity;

    #[ORM\Column]
    #[Groups(['order_item:read', 'order_item:write'])]
    private float $totalPrice;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['order_item:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['order_item:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

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

    public function getPriceProduct(): float
    {
        return $this->priceProduct;
    }

    public function setPriceProduct(float $priceProduct): static
    {
        $this->priceProduct = $priceProduct;

        return $this;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }


    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
