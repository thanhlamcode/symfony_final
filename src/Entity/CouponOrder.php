<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    normalizationContext: ['groups' => ['coupon_order:read']],
    denormalizationContext: ['groups' => ['coupon_order:write']]
)]
#[ORM\Entity]
class CouponOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['coupon_order:read'])]
    private UuidV7 $id;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['coupon_order:read', 'coupon_order:write'])]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: Coupon::class)]
    #[ORM\JoinColumn(name: 'coupon_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['coupon_order:read', 'coupon_order:write'])]
    private ?Coupon $coupon = null;

    #[ORM\Column]
    #[Groups(['coupon_order:read', 'coupon_order:write'])]
    private float $discountValue;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['coupon_order:read'])]
    private ?\DateTimeImmutable $appliedAt = null;

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

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): static
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getDiscountValue(): float
    {
        return $this->discountValue;
    }

    public function setDiscountValue(float $discountValue): static
    {
        $this->discountValue = $discountValue;

        return $this;
    }

    public function getAppliedAt(): ?\DateTimeImmutable
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(\DateTimeImmutable $appliedAt): static
    {
        $this->appliedAt = $appliedAt;

        return $this;
    }
}
