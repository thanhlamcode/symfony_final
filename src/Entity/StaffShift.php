<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\OpenApi\Model\Operation;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/staff_shifts/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(tags: ['StaffShift']),
            normalizationContext: ['groups' => ['api:staff_shift:get', 'api:staff_shift']],
        ),
        new GetCollection(
            uriTemplate: '/staff_shifts.{_format}',
            openapi: new Operation(tags: ['StaffShift']),
            normalizationContext: ['groups' => ['api:staff_shift:get_collection', 'api:staff_shift']]
        ),
        new Delete()
    ]
)]
class StaffShift
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:staff_shift'])]
    private ?UuidV7 $id = null;

    #[ORM\ManyToOne(targetEntity: Staff::class)]
    #[ORM\JoinColumn(name: 'staff_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['api:staff_shift'])]
    private ?Staff $staff = null;

    #[ORM\ManyToOne(targetEntity: Shop::class)]
    #[ORM\JoinColumn(name: 'shop_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['api:staff_shift'])]
    private ?Shop $shop = null;

    #[ORM\ManyToOne(targetEntity: WorkShift::class)]
    #[ORM\JoinColumn(name: 'work_shift_id', referencedColumnName: 'id', nullable: false)]
    #[Groups(['api:staff_shift'])]
    private ?WorkShift $workShift = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['api:staff_shift'])]
    private ?string $description = null;

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): void
    {
        $this->staff = $staff;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    public function setShop(?Shop $shop): void
    {
        $this->shop = $shop;
    }

    public function getWorkShift(): ?WorkShift
    {
        return $this->workShift;
    }

    public function setWorkShift(?WorkShift $workShift): void
    {
        $this->workShift = $workShift;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
