<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\CouponOrder;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\CouponOrder\UpdateCouponOrder;
use App\Entity\CouponOrder;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateCouponOrder> */
class UpdateCouponOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CouponOrder
    {
        $entity = $this->entityManager->find(CouponOrder::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('CouponOrder not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}