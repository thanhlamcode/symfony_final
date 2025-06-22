<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Product;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Product\UpdateProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateProduct> */
class UpdateProductProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Product
    {
        $entity = $this->entityManager->find(Product::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('Product not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}