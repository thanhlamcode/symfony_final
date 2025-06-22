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
use App\Entity\ProductStatus;
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
        $product = $this->entityManager->find(Product::class, $uriVariables['id']);
        
        if (!$product) {
            throw new \InvalidArgumentException('Product not found');
        }

        if ($data->name !== null) {
            $product->setName($data->name);
        }
        
        if ($data->price !== null) {
            $product->setPrice($data->price);
        }
        
        if ($data->category !== null) {
            $product->setCategory($data->category);
        }
        
        if ($data->description !== null) {
            $product->setDescription($data->description);
        }
        
        if ($data->imageUrl !== null) {
            $product->setImageUrl($data->imageUrl);
        }
        
        if ($data->status !== null) {
            $product->setStatus(ProductStatus::from($data->status));
        }

        $this->entityManager->flush();

        return $product;
    }
}