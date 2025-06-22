<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\StaffFeedback;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\StaffFeedback\CreateStaffFeedback;
use App\Entity\StaffFeedback;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateStaffFeedback> */
class CreateStaffFeedbackProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): StaffFeedback
    {
        $entity = new StaffFeedback();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}