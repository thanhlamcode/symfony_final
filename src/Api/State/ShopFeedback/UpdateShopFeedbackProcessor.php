<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\ShopFeedback;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\ShopFeedback\UpdateShopFeedback;
use App\Entity\ShopFeedback;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateShopFeedback> */
class UpdateShopFeedbackProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ShopFeedback
    {
        $entity = $this->entityManager->find(ShopFeedback::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('ShopFeedback not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}