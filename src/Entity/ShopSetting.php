<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    normalizationContext: ['groups' => ['shop_setting:read']],
    denormalizationContext: ['groups' => ['shop_setting:write']]
)]
#[ORM\Entity]
class ShopSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['shop_setting:read'])]
    private UuidV7 $id;

    #[ORM\OneToOne(inversedBy: 'shopSetting')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['shop_setting:read', 'shop_setting:write'])]
    private ?Shop $shop = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['shop_setting:read', 'shop_setting:write'])]
    private ?\DateTimeInterface $openTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['shop_setting:read', 'shop_setting:write'])]
    private ?\DateTimeInterface $closeTime = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['shop_setting:read', 'shop_setting:write'])]
    private array $workingDays = [];

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['shop_setting:read', 'shop_setting:write'])]
    private ?string $avatarUrl = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['shop_setting:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['shop_setting:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
    }

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): static
    {
        $this->shop = $shop;

        return $this;
    }

    public function getOpenTime(): ?\DateTimeInterface
    {
        return $this->openTime;
    }

    public function setOpenTime(?\DateTimeInterface $openTime): static
    {
        $this->openTime = $openTime;

        return $this;
    }

    public function getCloseTime(): ?\DateTimeInterface
    {
        return $this->closeTime;
    }

    public function setCloseTime(?\DateTimeInterface $closeTime): static
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    public function getWorkingDays(): array
    {
        return $this->workingDays;
    }

    public function setWorkingDays(array $workingDays): static
    {
        $this->workingDays = $workingDays;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

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