<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Order;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Order\UpdateOrder;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateOrder> */
class UpdateOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Order
    {
        $entity = $this->entityManager->find(Order::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('Order not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}