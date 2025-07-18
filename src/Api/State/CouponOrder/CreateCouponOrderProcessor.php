<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\CouponOrder;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\CouponOrder\CreateCouponOrder;
use App\Entity\CouponOrder;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateCouponOrder> */
class CreateCouponOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CouponOrder
    {
        $entity = new CouponOrder();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}