<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Category;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Category\CreateCategory;
use App\Entity\Category;
use App\Entity\CategoryStatus;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateCategory> */
class CreateCategoryProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Category
    {
        $category = new Category();

        $category->setName($data->name);
        $category->setDescription($data->description);
        $category->setStatus(CategoryStatus::from($data->status));

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}
