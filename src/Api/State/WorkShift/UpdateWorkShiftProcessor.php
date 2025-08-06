<?php

declare(strict_types=1);

namespace App\Api\State\WorkShift;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\WorkShift\UpdateWorkShift;
use App\Entity\WorkShift;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateWorkShift> */
class UpdateWorkShiftProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): WorkShift
    {
        $workShift = $this->entityManager->find(WorkShift::class, $uriVariables['id']);
        if (!$workShift) {
            throw new \InvalidArgumentException('WorkShift not found');
        }
        if ($data->name !== null) {
            $workShift->setName($data->name);
        }
        if ($data->description !== null) {
            $workShift->setDescription($data->description);
        }
        if ($data->startTime !== null) {
            $workShift->setStartTime($data->startTime);
        }
        if ($data->endTime !== null) {
            $workShift->setEndTime($data->endTime);
        }
        $this->entityManager->flush();
        return $workShift;
    }
}