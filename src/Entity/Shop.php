<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
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
use App\Service\UuidGenerator;

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
        'phone' => SearchFilterInterface::STRATEGY_PARTIAL,
        'address' => SearchFilterInterface::STRATEGY_PARTIAL,
        'status' => SearchFilterInterface::STRATEGY_EXACT,
        'shopCode' => SearchFilterInterface::STRATEGY_EXACT
    ]
)]
#[ApiFilter(
    filterClass: OrderFilter::class,
    properties: [
        'name' => 'ASC',
        'shopCode' => 'ASC',
        'createdAt' => 'DESC',
        'updatedAt' => 'DESC'
    ]
)]
#[ORM\Entity]
class Shop
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:shop'])]
    private ?UuidV7 $id = null;

    #[ORM\Column]
    #[Groups(['api:shop'])]
    private int $shopCode;

    #[ORM\Column(length: 255)]
    #[Groups(['api:shop'])]
    private string $name;

    #[ORM\Column(length: 255)]
    #[Groups(['api:shop'])]
    private string $address;

    #[ORM\Column(length: 180)]
    #[Groups(['api:shop'])]
    private string $email;

    #[ORM\Column(length: 255)]
    #[Groups(['api:shop'])]
    private string $phone;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api:shop'])]
    private ?string $avatarUrl = null;

    #[ORM\Column(enumType: ShopStatus::class)]
    #[Groups(['api:shop'])]
    private ShopStatus $status;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['api:shop'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['api:shop'])]
    private \DateTimeInterface $updatedAt;

    #[ORM\OneToOne(mappedBy: 'shop', cascade: ['persist', 'remove'])]
    private ?ShopSetting $shopSetting = null;

    public function __construct()
    {
        $this->status = ShopStatus::ACTIVE;
    }

    public function getId(): ?UuidV7
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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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