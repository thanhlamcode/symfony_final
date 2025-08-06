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
            uriTemplate: '/work_shifts/{id}.{_format}',
            requirements: [
                'id' => Requirement::UUID_V7,
            ],
            openapi: new Operation(tags: ['WorkShift']),
            normalizationContext: ['groups' => ['api:work_shift:get', 'api:work_shift']],
        ),
        new GetCollection(
            uriTemplate: '/work_shifts.{_format}',
            openapi: new Operation(tags: ['WorkShift']),
            normalizationContext: ['groups' => ['api:work_shift:get_collection', 'api:work_shift']]
        ),
        new Delete()
    ]
)]
class WorkShift
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['api:work_shift'])]
    private ?UuidV7 $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api:work_shift'])]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['api:work_shift'])]
    private ?string $description = null;

    #[ORM\Column(type: 'time')]
    #[Groups(['api:work_shift'])]
    private \DateTimeInterface $startTime;

    #[ORM\Column(type: 'time')]
    #[Groups(['api:work_shift'])]
    private \DateTimeInterface $endTime;

    public function getId(): ?UuidV7
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getStartTime(): \DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): \DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): void
    {
        $this->endTime = $endTime;
    }
}