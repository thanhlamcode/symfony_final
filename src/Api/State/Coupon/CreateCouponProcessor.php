<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Coupon;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Coupon\CreateCoupon;
use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DiscountType;
use App\Entity\CouponStatus;

/** @implements ProcessorInterface<CreateCoupon> */
class CreateCouponProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Coupon
    {
        $entity = new Coupon();

        // Set properties from request data
        $entity->setId($data->id);
        
        if ($data->name !== null) {
            $entity->setName($data->name);
        }
        
        if ($data->code !== null) {
            $entity->setCode($data->code);
        }
        
        if ($data->discountType !== null) {
            $entity->setDiscountType(DiscountType::from($data->discountType));
        }
        
        if ($data->value !== null) {
            $entity->setValue((float) $data->value);
        }
        
        if ($data->quantity !== null) {
            $entity->setQuantity((int) $data->quantity);
        }
        
        if ($data->status !== null) {
            $entity->setStatus(CouponStatus::from($data->status));
        }
        
        if ($data->minOrderValue !== null) {
            $entity->setMinOrderValue((float) $data->minOrderValue);
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}