<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    normalizationContext: ['groups' => ['order:read']],
    denormalizationContext: ['groups' => ['order:write']]
)]
#[ApiFilter(
    filterClass: SearchFilter::class,
    properties: [
        'customer.name' => SearchFilterInterface::STRATEGY_PARTIAL,
        'customer.email' => SearchFilterInterface::STRATEGY_PARTIAL,
        'shop.name' => SearchFilterInterface::STRATEGY_PARTIAL,
        'staff.name' => SearchFilterInterface::STRATEGY_PARTIAL,
        'paymentMethod' => SearchFilterInterface::STRATEGY_EXACT,
        'note' => SearchFilterInterface::STRATEGY_PARTIAL
    ]
)]
#[ApiFilter(
    filterClass: OrderFilter::class,
    properties: [
        'total' => 'ASC',
        'subTotal' => 'ASC',
        'createdAt' => 'DESC',
        'updatedAt' => 'DESC'
    ]
)]
#[ORM\Entity]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['order:read'])]
    private UuidV7 $id;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['order:read', 'order:write'])]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(targetEntity: Shop::class)]
    #[ORM\JoinColumn(name: 'shop_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['order:read', 'order:write'])]
    private ?Shop $shop = null;

    #[ORM\ManyToOne(targetEntity: Staff::class)]
    #[ORM\JoinColumn(name: 'staff_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?Staff $staff = null;

    #[ORM\Column]
    #[Groups(['order:read', 'order:write'])]
    private float $subTotal;

    #[ORM\Column]
    #[Groups(['order:read', 'order:write'])]
    private float $discountTotal;

    #[ORM\Column]
    #[Groups(['order:read', 'order:write'])]
    private float $total;

    #[ORM\Column(enumType: PaymentMethod::class)]
    #[Groups(['order:read', 'order:write'])]
    private PaymentMethod $paymentMethod;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['order:read', 'order:write'])]
    private ?string $note = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['order:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['order:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'order', cascade: ['persist', 'remove'])]
    private ?ReturnOrder $returnOrder = null;

    public function getId(): UuidV7
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
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

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): static
    {
        $this->staff = $staff;

        return $this;
    }

    public function getSubTotal(): float
    {
        return $this->subTotal;
    }

    public function setSubTotal(float $subTotal): static
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    public function getDiscountTotal(): float
    {
        return $this->discountTotal;
    }

    public function setDiscountTotal(float $discountTotal): static
    {
        $this->discountTotal = $discountTotal;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

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

    public function getReturnOrder(): ?ReturnOrder
    {
        return $this->returnOrder;
    }

    public function setReturnOrder(ReturnOrder $returnOrder): static
    {
        // unset the owning side of the relation if necessary
        if ($returnOrder === null && $this->returnOrder !== null) {
            $this->returnOrder->setOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($returnOrder !== null && $returnOrder->getOrder() !== $this) {
            $returnOrder->setOrder($this);
        }

        $this->returnOrder = $returnOrder;

        return $this;
    }
}
