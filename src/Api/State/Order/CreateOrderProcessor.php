<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Order;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Order\CreateOrder;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateOrder> */
class CreateOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Order
    {
        $entity = new Order();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}