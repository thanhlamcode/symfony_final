<?php

declare(strict_types=1);

namespace App\Api\State\Staff;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Staff\CreateStaffShift;
use App\Entity\StaffShift;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateStaffShift> */
class CreateStaffShiftProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): StaffShift
    {
        $staffShift = new StaffShift();
        $staffShift->setStaff($data->staff);
        $staffShift->setShop($data->shop);
        $staffShift->setWorkShift($data->workShift);
        $staffShift->setDescription($data->description);
        $this->entityManager->persist($staffShift);
        $this->entityManager->flush();
        return $staffShift;
    }
}