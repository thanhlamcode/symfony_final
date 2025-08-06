<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Serializer\Attribute\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ApiResource]
class Delivery
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['delivery'])]
    private ?UuidV7 $id = null;

    #[ORM\OneToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['delivery'])]
    private ?Order $order = null;

    #[ORM\Column(enumType: DeliveryStatus::class)]
    #[Groups(['delivery'])]
    private DeliveryStatus $status = DeliveryStatus::PENDING;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['delivery'])]
    private ?string $shipperName = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['delivery'])]
    private ?string $shipperPhone = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['delivery'])]
    private ?string $trackingCode = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['delivery'])]
    private ?\DateTimeInterface $estimatedDelivery = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['delivery'])]
    private ?\DateTimeInterface $deliveredAt = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['delivery'])]
    private ?string $note = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['delivery'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['delivery'])]
    private \DateTimeInterface $updatedAt;

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

    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    public function getStatus(): DeliveryStatus
    {
        return $this->status;
    }

    public function setStatus(DeliveryStatus $status): void
    {
        $this->status = $status;
    }

    public function getShipperName(): ?string
    {
        return $this->shipperName;
    }

    public function setShipperName(?string $shipperName): void
    {
        $this->shipperName = $shipperName;
    }

    public function getShipperPhone(): ?string
    {
        return $this->shipperPhone;
    }

    public function setShipperPhone(?string $shipperPhone): void
    {
        $this->shipperPhone = $shipperPhone;
    }

    public function getTrackingCode(): ?string
    {
        return $this->trackingCode;
    }

    public function setTrackingCode(?string $trackingCode): void
    {
        $this->trackingCode = $trackingCode;
    }

    public function getEstimatedDelivery(): ?\DateTimeInterface
    {
        return $this->estimatedDelivery;
    }

    public function setEstimatedDelivery(?\DateTimeInterface $estimatedDelivery): void
    {
        $this->estimatedDelivery = $estimatedDelivery;
    }

    public function getDeliveredAt(): ?\DateTimeInterface
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(?\DateTimeInterface $deliveredAt): void
    {
        $this->deliveredAt = $deliveredAt;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
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
}
