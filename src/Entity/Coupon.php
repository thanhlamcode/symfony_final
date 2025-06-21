<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;
use App\DiscountType;
use App\CouponStatus;

#[ApiResource(
    normalizationContext: ['groups' => ['coupon:read']],
    denormalizationContext: ['groups' => ['coupon:write']]
)]
#[ORM\Entity]
class Coupon
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['coupon:read'])]
    private UuidV7 $id;

    #[ORM\Column(length: 255)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private string $name;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['coupon:read', 'coupon:write'])]
    private string $code;

    #[ORM\ManyToOne(inversedBy: 'coupons')]
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

    #[ORM\OneToMany(mappedBy: 'coupon', targetEntity: CouponOrder::class)]
    private Collection $couponOrders;

    public function __construct()
    {
        $this->id = new UuidV7();
        $this->status = CouponStatus::ACTIVE;
        $this->couponOrders = new ArrayCollection();
    }

    public function getId(): UuidV7
    {
        return $this->id;
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

    /**
     * @return Collection<int, CouponOrder>
     */
    public function getCouponOrders(): Collection
    {
        return $this->couponOrders;
    }

    public function addCouponOrder(CouponOrder $couponOrder): static
    {
        if (!$this->couponOrders->contains($couponOrder)) {
            $this->couponOrders->add($couponOrder);
            $couponOrder->setCoupon($this);
        }

        return $this;
    }

    public function removeCouponOrder(CouponOrder $couponOrder): static
    {
        if ($this->couponOrders->removeElement($couponOrder)) {
            // set the owning side to null (unless already changed)
            if ($couponOrder->getCoupon() === $this) {
                $couponOrder->setCoupon(null);
            }
        }

        return $this;
    }
}
