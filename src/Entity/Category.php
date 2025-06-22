<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/categories/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(
                tags: ['Category']
            ),
            normalizationContext: ['groups' => ['api:category:get', 'api:category']],
        ),
        new GetCollection(
            uriTemplate: '/categories.{_format}',
            openapi: new Operation(
                tags: ['Category']
            ),
            normalizationContext: ['groups' => ['api:category:get_collection', 'api:category']]
        ),
        new Delete()
    ]
)]
#[ORM\Entity]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:category', 'api:category:get', 'api:category:get_collection'])]
    private UuidV7 $id;

    #[ORM\Column(length: 255)]
    #[Groups(['api:category', 'api:category:get', 'api:category:get_collection'])]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['api:category', 'api:category:get', 'api:category:get_collection'])]
    private ?string $description = null;

    #[ORM\Column(enumType: CategoryStatus::class)]
    #[Groups(['api:category', 'api:category:get', 'api:category:get_collection'])]
    private CategoryStatus $status;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:category', 'api:category:get', 'api:category:get_collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:category', 'api:category:get', 'api:category:get_collection'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->id = new UuidV7();
        $this->status = CategoryStatus::ACTIVE;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): CategoryStatus
    {
        return $this->status;
    }

    public function setStatus(CategoryStatus $status): static
    {
        $this->status = $status;

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