<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\OrderFeedback;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\OrderFeedback\CreateOrderFeedback;
use App\Entity\OrderFeedback;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateOrderFeedback> */
class CreateOrderFeedbackProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): OrderFeedback
    {
        $entity = new OrderFeedback();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}