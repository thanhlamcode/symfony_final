<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;
use App\Entity\CustomerStatus;
use App\Entity\Gender;

#[ApiResource(
    normalizationContext: ['groups' => ['customer:read']],
    denormalizationContext: ['groups' => ['customer:write']]
)]
#[ORM\Entity]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['customer:read'])]
    private UuidV7 $id;

    #[ORM\Column(length: 255)]
    #[Groups(['customer:read', 'customer:write'])]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $phone = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private string $email;

    #[ORM\Column(length: 255, nullable: true, enumType: Gender::class)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?Gender $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(enumType: CustomerStatus::class)]
    #[Groups(['customer:read', 'customer:write'])]
    private CustomerStatus $status;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $address = null;

    #[ORM\ManyToOne(targetEntity: MemberShipLevel::class)]
    #[ORM\JoinColumn(name: 'member_ship_level_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?MemberShipLevel $memberShipLevel = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['customer:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['customer:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->id = new UuidV7();
        $this->status = CustomerStatus::ACTIVE;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

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

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getStatus(): CustomerStatus
    {
        return $this->status;
    }

    public function setStatus(CustomerStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getMemberShipLevel(): ?MemberShipLevel
    {
        return $this->memberShipLevel;
    }

    public function setMemberShipLevel(?MemberShipLevel $memberShipLevel): static
    {
        $this->memberShipLevel = $memberShipLevel;

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