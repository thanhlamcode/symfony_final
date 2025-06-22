<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Staff;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Staff\UpdateStaff;
use App\Entity\Staff;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateStaff> */
class UpdateStaffProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Staff
    {
        $staff = $this->entityManager->find(Staff::class, $data->id);
        
        if (!$staff) {
            throw new \InvalidArgumentException('Staff not found');
        }

        if ($data->name !== null) {
            $staff->setName($data->name);
        }
        
        if ($data->email !== null) {
            $staff->setEmail($data->email);
        }
        
        if ($data->phone !== null) {
            $staff->setPhone($data->phone);
        }
        
        if ($data->position !== null) {
            $staff->setPosition($data->position);
        }
        
        if ($data->isActive !== null) {
            $staff->setIsActive($data->isActive);
        }

        $this->entityManager->flush();

        return $staff;
    }
} 