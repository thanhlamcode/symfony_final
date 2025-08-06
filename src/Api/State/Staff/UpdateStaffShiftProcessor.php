<?php

declare(strict_types=1);

namespace App\Api\State\Staff;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Staff\UpdateStaffShift;
use App\Entity\StaffShift;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateStaffShift> */
class UpdateStaffShiftProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): StaffShift
    {
        $staffShift = $this->entityManager->find(StaffShift::class, $uriVariables['id']);
        if (!$staffShift) {
            throw new \InvalidArgumentException('StaffShift not found');
        }
        if ($data->staff !== null) {
            $staffShift->setStaff($data->staff);
        }
        if ($data->shop !== null) {
            $staffShift->setShop($data->shop);
        }
        if ($data->workShift !== null) {
            $staffShift->setWorkShift($data->workShift);
        }
        if ($data->description !== null) {
            $staffShift->setDescription($data->description);
        }
        $this->entityManager->flush();
        return $staffShift;
    }
}