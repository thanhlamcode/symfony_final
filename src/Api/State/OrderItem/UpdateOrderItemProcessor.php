<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\OrderItem;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\OrderItem\UpdateOrderItem;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateOrderItem> */
class UpdateOrderItemProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): OrderItem
    {
        $entity = $this->entityManager->find(OrderItem::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('OrderItem not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}