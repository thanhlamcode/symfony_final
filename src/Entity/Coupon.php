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
            uriTemplate: '/coupons/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(
                tags: ['Coupon']
            ),
            normalizationContext: ['groups' => ['coupon:read']],
            security: "is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')"
        ),
        new GetCollection(
            uriTemplate: '/coupons.{_format}',
            openapi: new Operation(
                tags: ['Coupon']
            ),
            normalizationContext: ['groups' => ['coupon:read']],
            security: "is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        )
    ],
    normalizationContext: ['groups' => ['coupon:read']],
    denormalizationContext: ['groups' => ['coupon:write']]
)]
#[ORM\Entity]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['coupon:read'])]
    private ?UuidV7 $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private string $name;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private string $code;

    #[ORM\ManyToOne(targetEntity: PromotionProgram::class)]
    #[ORM\JoinColumn(name: 'promotion_program_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private ?PromotionProgram $promotionProgram = null;

    #[ORM\Column(enumType: DiscountType::class)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private DiscountType $discountType;

    #[ORM\Column]
    #[Groups(['coupon:read', 'coupon:write'])]
    private float $value;

    #[ORM\Column]
    #[Groups(['coupon:read', 'coupon:write'])]
    private int $quantity;

    #[ORM\Column(enumType: CouponStatus::class)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private CouponStatus $status;

    #[ORM\Column(nullable: true)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private ?float $minOrderValue = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['coupon:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['coupon:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->status = CouponStatus::ACTIVE;
    }

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

    public function setId(?UuidV7 $id): void
    {
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

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getPromotionProgram(): ?PromotionProgram
    {
        return $this->promotionProgram;
    }

    public function setPromotionProgram(?PromotionProgram $promotionProgram): static
    {
        $this->promotionProgram = $promotionProgram;

        return $this;
    }

    public function getDiscountType(): DiscountType
    {
        return $this->discountType;
    }

    public function setDiscountType(DiscountType $discountType): static
    {
        $this->discountType = $discountType;

        return $this;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

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

    public function getStatus(): CouponStatus
    {
        return $this->status;
    }

    public function setStatus(CouponStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getMinOrderValue(): ?float
    {
        return $this->minOrderValue;
    }

    public function setMinOrderValue(?float $minOrderValue): static
    {
        $this->minOrderValue = $minOrderValue;

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
