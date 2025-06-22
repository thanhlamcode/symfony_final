<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Coupon;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Coupon\UpdateCoupon;
use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateCoupon> */
class UpdateCouponProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Coupon
    {
        $entity = $this->entityManager->find(Coupon::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('Coupon not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}