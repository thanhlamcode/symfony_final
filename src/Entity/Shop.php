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
            uriTemplate: '/shops/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(
                tags: ['Shop']
            ),
            normalizationContext: ['groups' => ['api:shop:get', 'api:shop']],
        ),
        new GetCollection(
            uriTemplate: '/shops.{_format}',
            openapi: new Operation(
                tags: ['Shop']
            ),
            normalizationContext: ['groups' => ['api:shop:get_collection', 'api:shop']]
        ),
        new Delete()
    ]
)]
#[ApiFilter(
    filterClass: SearchFilter::class,
    properties: [
        'name' => SearchFilterInterface::STRATEGY_PARTIAL,
        'email' => SearchFilterInterface::STRATEGY_PARTIAL,
        'status' => SearchFilterInterface::STRATEGY_EXACT,
        'shopCode' => SearchFilterInterface::STRATEGY_EXACT
    ]
)]
#[ORM\Entity]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private UuidV7 $id;

    #[ORM\Column(unique: true)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private int $shopCode;

    #[ORM\Column(length: 255)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private string $address;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private string $email;

    #[ORM\Column(length: 255)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private string $phone;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private ?string $avatarUrl = null;

    #[ORM\Column(enumType: ShopStatus::class)]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private ShopStatus $status;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:shop', 'api:shop:get', 'api:shop:get_collection'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'shop', cascade: ['persist', 'remove'])]
    private ?ShopSetting $shopSetting = null;

    public function __construct()
    {
        $this->id = new UuidV7();
        $this->status = ShopStatus::ACTIVE;
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

    public function getShopCode(): int
    {
        return $this->shopCode;
    }

    public function setShopCode(int $shopCode): static
    {
        $this->shopCode = $shopCode;

        return $this;
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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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

    public function getStatus(): ShopStatus
    {
        return $this->status;
    }

    public function setStatus(ShopStatus $status): static
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

    public function getShopSetting(): ?ShopSetting
    {
        return $this->shopSetting;
    }

    public function setShopSetting(ShopSetting $shopSetting): static
    {
        // unset the owning side of the relation if necessary
        if ($shopSetting === null && $this->shopSetting !== null) {
            $this->shopSetting->setShop(null);
        }

        // set the owning side of the relation if necessary
        if ($shopSetting !== null && $shopSetting->getShop() !== $this) {
            $shopSetting->setShop($this);
        }

        $this->shopSetting = $shopSetting;

        return $this;
    }
} 