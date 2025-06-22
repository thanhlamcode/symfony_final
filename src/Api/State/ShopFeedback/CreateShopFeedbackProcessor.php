<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\ShopFeedback;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\ShopFeedback\CreateShopFeedback;
use App\Entity\ShopFeedback;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateShopFeedback> */
class CreateShopFeedbackProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ShopFeedback
    {
        $entity = new ShopFeedback();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}