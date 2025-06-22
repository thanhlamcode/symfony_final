<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Staff;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Staff\CreateStaff;
use App\Entity\Staff;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateStaff> */
class CreateStaffProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Staff
    {
        $staff = new Staff();

        $staff->setId($data->id);
        $staff->setName($data->name);
        $staff->setEmail($data->email);
        $staff->setPhone($data->phone);
        $staff->setPosition($data->position);
        $staff->setIsActive($data->isActive);

        $this->entityManager->persist($staff);
        $this->entityManager->flush();

        return $staff;
    }
} 