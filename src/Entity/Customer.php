<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\Serializer\Filter\PropertyFilter;
use App\Service\UuidGenerator;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\UuidV7;
use App\Entity\CustomerStatus;
use App\Entity\Gender;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/customers/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(
                tags: ['Customer']
            ),
            normalizationContext: ['groups' => ['api:customer:read']],
        ),
        new GetCollection(
            uriTemplate: '/customers.{_format}',
            openapi: new Operation(
                tags: ['Customer']
            ),
            normalizationContext: ['groups' => ['api:customer:read']]
        ),
        new Delete()
    ]
)]
#[ApiFilter(
    filterClass: SearchFilter::class,
    properties: [
        'name' => SearchFilterInterface::STRATEGY_PARTIAL,
        'email' => SearchFilterInterface::STRATEGY_PARTIAL,
        'status' => SearchFilterInterface::STRATEGY_EXACT,
        'gender' => SearchFilterInterface::STRATEGY_EXACT
    ]
)]
#[ORM\Entity]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:customer:read'])]
    private ?UuidV7 $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api:customer:read'])]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api:customer:read'])]
    private ?string $phone = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['api:customer:read'])]
    private string $email;

    #[ORM\Column(length: 255, nullable: true, enumType: Gender::class)]
    #[Groups(['api:customer:read'])]
    private ?Gender $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['api:customer:read'])]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(enumType: CustomerStatus::class)]
    #[Groups(['api:customer:read'])]
    private CustomerStatus $status;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['api:customer:read'])]
    private ?string $address = null;

    #[ORM\ManyToOne(targetEntity: MemberShipLevel::class)]
    #[ORM\JoinColumn(name: 'member_ship_level_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['api:customer:read'])]
    private ?MemberShipLevel $memberShipLevel = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['api:customer:read'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['api:customer:read'])]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->status = CustomerStatus::ACTIVE;
    }

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

    public function setId(UuidV7|string $id): void
    {
        if (is_string($id)) {
            $id = UuidV7::fromString($id);
        }
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