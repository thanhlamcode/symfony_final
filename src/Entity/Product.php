<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/products/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(
                tags: ['Product']
            ),
            normalizationContext: ['groups' => ['api:product:get', 'api:product']],
        ),
        new GetCollection(
            uriTemplate: '/products.{_format}',
            openapi: new Operation(
                tags: ['Product']
            ),
            normalizationContext: ['groups' => ['api:product:get_collection', 'api:product']]
        ),
        new Delete()
    ]
)]
#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private UuidV7 $id;

    #[ORM\Column(length: 255)]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private string $name;

    #[ORM\Column(enumType: ProductStatus::class)]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private ProductStatus $status;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private ?Category $category = null;

    #[ORM\Column]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private int $price;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private ?string $imageUrl = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private ?string $description = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:product', 'api:product:get', 'api:product:get_collection'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->id = new UuidV7();
        $this->status = ProductStatus::ACTIVE;
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function setId(UuidV7|string $id): void
    {
        if (is_string($id)) {
            $id = UuidV7::fromString($id);
        }
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ProductStatus
    {
        return $this->status;
    }

    public function setStatus(ProductStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

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