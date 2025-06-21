<?php

namespace App\Entity;

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
#[ORM\Entity]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['order:read'])]
    private UuidV7 $id;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read', 'order:write'])]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read', 'order:write'])]
    private ?Shop $shop = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
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

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class, cascade: ['persist', 'remove'])]
    private Collection $orderItems;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderFeedback::class)]
    private Collection $orderFeedbacks;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: CouponOrder::class)]
    private Collection $couponOrders;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: CustomerPointTransaction::class)]
    private Collection $customerPointTransactions;

    #[ORM\OneToOne(mappedBy: 'order', cascade: ['persist', 'remove'])]
    private ?ReturnOrder $returnOrder = null;

    public function __construct()
    {
        $this->id = new UuidV7();
        $this->orderItems = new ArrayCollection();
        $this->orderFeedbacks = new ArrayCollection();
        $this->couponOrders = new ArrayCollection();
        $this->customerPointTransactions = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderFeedback>
     */
    public function getOrderFeedbacks(): Collection
    {
        return $this->orderFeedbacks;
    }

    public function addOrderFeedback(OrderFeedback $orderFeedback): static
    {
        if (!$this->orderFeedbacks->contains($orderFeedback)) {
            $this->orderFeedbacks->add($orderFeedback);
            $orderFeedback->setOrder($this);
        }

        return $this;
    }

    public function removeOrderFeedback(OrderFeedback $orderFeedback): static
    {
        if ($this->orderFeedbacks->removeElement($orderFeedback)) {
            // set the owning side to null (unless already changed)
            if ($orderFeedback->getOrder() === $this) {
                $orderFeedback->setOrder(null);
            }
        }

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
            $couponOrder->setOrder($this);
        }

        return $this;
    }

    public function removeCouponOrder(CouponOrder $couponOrder): static
    {
        if ($this->couponOrders->removeElement($couponOrder)) {
            // set the owning side to null (unless already changed)
            if ($couponOrder->getOrder() === $this) {
                $couponOrder->setOrder(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CustomerPointTransaction>
     */
    public function getCustomerPointTransactions(): Collection
    {
        return $this->customerPointTransactions;
    }

    public function addCustomerPointTransaction(CustomerPointTransaction $customerPointTransaction): static
    {
        if (!$this->customerPointTransactions->contains($customerPointTransaction)) {
            $this->customerPointTransactions->add($customerPointTransaction);
            $customerPointTransaction->setOrder($this);
        }

        return $this;
    }

    public function removeCustomerPointTransaction(CustomerPointTransaction $customerPointTransaction): static
    {
        if ($this->customerPointTransactions->removeElement($customerPointTransaction)) {
            // set the owning side to null (unless already changed)
            if ($customerPointTransaction->getOrder() === $this) {
                $customerPointTransaction->setOrder(null);
            }
        }

        return $this;
    }

    public function getReturnOrder(): ?ReturnOrder
    {
        return $this->returnOrder;
    }

    public function setReturnOrder(ReturnOrder $returnOrder): static
    {
        // set the owning side of the relation if necessary
        if ($returnOrder->getOrder() !== $this) {
            $returnOrder->setOrder($this);
        }

        $this->returnOrder = $returnOrder;

        return $this;
    }
}