<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Category;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Category\UpdateCategory;
use App\Entity\Category;
use App\Entity\CategoryStatus;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateCategory> */
class UpdateCategoryProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Category
    {
        $category = $this->entityManager->find(Category::class, $uriVariables['id']);
        
        if (!$category) {
            throw new \InvalidArgumentException('Category not found');
        }

        if ($data->name !== null) {
            $category->setName($data->name);
        }
        
        if ($data->description !== null) {
            $category->setDescription($data->description);
        }
        
        if ($data->status !== null) {
            $category->setStatus(CategoryStatus::from($data->status));
        }

        $this->entityManager->flush();

        return $category;
    }
}