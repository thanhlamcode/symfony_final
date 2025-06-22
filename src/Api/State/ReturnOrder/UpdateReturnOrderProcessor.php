<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\ReturnOrder;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\ReturnOrder\UpdateReturnOrder;
use App\Entity\ReturnOrder;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateReturnOrder> */
class UpdateReturnOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ReturnOrder
    {
        $entity = $this->entityManager->find(ReturnOrder::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('ReturnOrder not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}