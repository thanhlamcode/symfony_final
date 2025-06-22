<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\ReturnOrder;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\ReturnOrder\CreateReturnOrder;
use App\Entity\ReturnOrder;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateReturnOrder> */
class CreateReturnOrderProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ReturnOrder
    {
        $entity = new ReturnOrder();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}