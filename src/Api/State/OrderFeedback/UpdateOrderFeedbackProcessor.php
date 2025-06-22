<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\OrderFeedback;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\OrderFeedback\UpdateOrderFeedback;
use App\Entity\OrderFeedback;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateOrderFeedback> */
class UpdateOrderFeedbackProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): OrderFeedback
    {
        $entity = $this->entityManager->find(OrderFeedback::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('OrderFeedback not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}