<?php

declare(strict_types=1);

namespace App\Api\State\WorkShift;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\WorkShift\CreateWorkShift;
use App\Entity\WorkShift;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateWorkShift> */
class CreateWorkShiftProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): WorkShift
    {
        $workShift = new WorkShift();
        $workShift->setName($data->name);
        $workShift->setDescription($data->description);
        $workShift->setStartTime($data->startTime);
        $workShift->setEndTime($data->endTime);
        $this->entityManager->persist($workShift);
        $this->entityManager->flush();
        return $workShift;
    }
}