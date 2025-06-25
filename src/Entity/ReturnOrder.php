<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    normalizationContext: ['groups' => ['return_order:read']],
    denormalizationContext: ['groups' => ['return_order:write']]
)]
#[ORM\Entity]
class ReturnOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['return_order:read', 'return_order:write'])]
    private ?UuidV7 $id = null;

    #[ORM\OneToOne(inversedBy: 'returnOrder')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['return_order:read', 'return_order:write'])]
    private ?Order $order = null;

    #[ORM\Column(enumType: ReturnOrderStatus::class)]
    #[Groups(['return_order:read', 'return_order:write'])]
    private ReturnOrderStatus $status;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['return_order:read', 'return_order:write'])]
    private ?string $reason = null;

    #[ORM\Column]
    #[Groups(['return_order:read', 'return_order:write'])]
    private float $refundAmount;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['return_order:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['return_order:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

    public function setId(?UuidV7 $id): void
    {
        $this->id = $id;
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

    public function getStatus(): ReturnOrderStatus
    {
        return $this->status;
    }

    public function setStatus(ReturnOrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getRefundAmount(): float
    {
        return $this->refundAmount;
    }

    public function setRefundAmount(float $refundAmount): static
    {
        $this->refundAmount = $refundAmount;

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
