<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    normalizationContext: ['groups' => ['member_ship_level:read']],
    denormalizationContext: ['groups' => ['member_ship_level:write']]
)]
#[ORM\Entity]
class MemberShipLevel
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['member_ship_level:read'])]
    private UuidV7 $id;

    #[ORM\Column(length: 255, enumType: MemberShipLevelType::class)]
    #[Groups(['member_ship_level:read', 'member_ship_level:write'])]
    private MemberShipLevelType $type;

    #[ORM\Column]
    #[Groups(['member_ship_level:read', 'member_ship_level:write'])]
    private int $point;

    #[ORM\Column]
    #[Groups(['member_ship_level:read', 'member_ship_level:write'])]
    private float $discountRate;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['member_ship_level:read', 'member_ship_level:write'])]
    private ?string $description = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['member_ship_level:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['member_ship_level:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->id = new UuidV7();
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getType(): MemberShipLevelType
    {
        return $this->type;
    }

    public function setType(MemberShipLevelType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPoint(): int
    {
        return $this->point;
    }

    public function setPoint(int $point): static
    {
        $this->point = $point;

        return $this;
    }

    public function getDiscountRate(): float
    {
        return $this->discountRate;
    }

    public function setDiscountRate(float $discountRate): static
    {
        $this->discountRate = $discountRate;

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