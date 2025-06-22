<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Product;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Product\CreateProduct;
use App\Entity\Product;
use App\Entity\ProductStatus;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateProduct> */
class CreateProductProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Product
    {
        $product = new Product();

        $product->setName($data->name);
        $product->setPrice($data->price);
        $product->setCategory($data->category);
        $product->setDescription($data->description);
        $product->setImageUrl($data->imageUrl);
        $product->setStatus(ProductStatus::from($data->status));

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }
}