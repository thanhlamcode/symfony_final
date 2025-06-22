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
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Attribute\Groups;
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
            normalizationContext: ['groups' => ['api:customer:get', 'api:customer']],
        ),
        new GetCollection(
            uriTemplate: '/customers.{_format}',
            openapi: new Operation(
                tags: ['Customer']
            ),
            normalizationContext: ['groups' => ['api:customer:get_collection', 'api:customer']]
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
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private UuidV7 $id;

    #[ORM\Column(length: 255)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private string $name;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private ?string $phone = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private string $email;

    #[ORM\Column(length: 255, nullable: true, enumType: Gender::class)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private ?Gender $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(enumType: CustomerStatus::class)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private CustomerStatus $status;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private ?string $address = null;

    #[ORM\ManyToOne(targetEntity: MemberShipLevel::class)]
    #[ORM\JoinColumn(name: 'member_ship_level_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private ?MemberShipLevel $memberShipLevel = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['api:customer', 'api:customer:get', 'api:customer:get_collection'])]
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