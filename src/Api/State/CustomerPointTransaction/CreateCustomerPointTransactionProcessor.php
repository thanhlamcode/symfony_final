<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\CustomerPointTransaction;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\CustomerPointTransaction\CreateCustomerPointTransaction;
use App\Entity\CustomerPointTransaction;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateCustomerPointTransaction> */
class CreateCustomerPointTransactionProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CustomerPointTransaction
    {
        $entity = new CustomerPointTransaction();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}