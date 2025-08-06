<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Serializer\Attribute\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ApiResource]
class DeliveryTracking
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['delivery_tracking'])]
    private ?UuidV7 $id = null;

    #[ORM\ManyToOne(targetEntity: Delivery::class)]
    #[ORM\JoinColumn(name: 'delivery_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['delivery_tracking'])]
    private ?Delivery $delivery = null;

    #[ORM\Column(enumType: DeliveryStatus::class)]
    #[Groups(['delivery_tracking'])]
    private DeliveryStatus $status;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['delivery_tracking'])]
    private ?string $location = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['delivery_tracking'])]
    private ?string $note = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['delivery_tracking'])]
    private \DateTimeInterface $createdAt;

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

    public function setId(?UuidV7 $id): void
    {
        $this->id = $id;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): void
    {
        $this->delivery = $delivery;
    }

    public function getStatus(): DeliveryStatus
    {
        return $this->status;
    }

    public function setStatus(DeliveryStatus $status): void
    {
        $this->status = $status;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): void
    {
        $this->location = $location;
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
}
