<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;

#[ApiResource(
    normalizationContext: ['groups' => ['order_feedback:read']],
    denormalizationContext: ['groups' => ['order_feedback:write']]
)]
#[ORM\Entity]
class OrderFeedback
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['order_feedback:read'])]
    private UuidV7 $id;

    #[ORM\ManyToOne(inversedBy: 'orderFeedbacks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order_feedback:read', 'order_feedback:write'])]
    private ?Order $order = null;

    #[ORM\Column(type: 'smallint', enumType: RatingValue::class)]
    #[Groups(['order_feedback:read', 'order_feedback:write'])]
    private RatingValue $rating;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['order_feedback:read', 'order_feedback:write'])]
    private ?string $comment = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['order_feedback:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['order_feedback:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->id = new UuidV7();
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

    public function getRating(): RatingValue
    {
        return $this->rating;
    }

    public function setRating(RatingValue $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

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