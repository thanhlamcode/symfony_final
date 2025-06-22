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
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\UuidV7;
use App\Service\UuidGenerator;
use Doctrine\DBAL\Types\Types;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/staff/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(
                tags: ['Staff']
            ),
            normalizationContext: ['groups' => ['api:staff:get', 'api:staff']],
        ),
        new GetCollection(
            uriTemplate: '/staff.{_format}',
            openapi: new Operation(
                tags: ['Staff']
            ),
            normalizationContext: ['groups' => ['api:staff:get_collection', 'api:staff']]
        ),
        new Delete()
    ]
)]
#[ORM\Entity]
class Staff
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:staff:read'])]
    private ?UuidV7 $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api:staff:read'])]
    private string $name;

    #[ORM\Column(length: 180)]
    #[Groups(['api:staff:read'])]
    private string $email;

    #[ORM\Column(length: 255)]
    #[Groups(['api:staff:read'])]
    private string $phone;

    #[ORM\Column(length: 255, nullable: true, enumType: Gender::class)]
    #[Groups(['api:staff:read'])]
    private ?Gender $gender = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['api:staff:read'])]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(enumType: StaffStatus::class)]
    #[Groups(['api:staff:read'])]
    private StaffStatus $status;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['api:staff:read'])]
    private ?string $address = null;

    #[ORM\ManyToOne(targetEntity: Shop::class)]
    #[ORM\JoinColumn(name: 'shop_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['api:staff:read'])]
    private ?Shop $shop = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'create')]
    #[Groups(['api:staff:read'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(['api:staff:read'])]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->status = StaffStatus::ACTIVE;
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getStatus(): StaffStatus
    {
        return $this->status;
    }

    public function setStatus(StaffStatus $status): void
    {
        $this->status = $status;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): void
    {
        $this->shop = $shop;
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