<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\StaffFeedback;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\StaffFeedback\UpdateStaffFeedback;
use App\Entity\StaffFeedback;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateStaffFeedback> */
class UpdateStaffFeedbackProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): StaffFeedback
    {
        $entity = $this->entityManager->find(StaffFeedback::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('StaffFeedback not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}