<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
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
            uriTemplate: '/staff/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(
                tags: ['Staff']
            ),
            normalizationContext: ['groups' => ['api:staff:get', 'api:staff']],
        ),
        new GetCollection(
            uriTemplate: '/staff.{_format}',
            openapi: new Operation(
                tags: ['Staff']
            ),
            normalizationContext: ['groups' => ['api:staff:get_collection', 'api:staff']]
        ),
        new Delete()
    ]
)]
#[ORM\Entity]
class Staff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private UuidV7 $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private string $email;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private string $position;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private bool $isActive = true;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['api:staff', 'api:staff:get', 'api:staff:get_collection'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->status = StaffStatus::ACTIVE;
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
} 