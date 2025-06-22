<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\CustomerPointTransaction;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\CustomerPointTransaction\UpdateCustomerPointTransaction;
use App\Entity\CustomerPointTransaction;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateCustomerPointTransaction> */
class UpdateCustomerPointTransactionProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CustomerPointTransaction
    {
        $entity = $this->entityManager->find(CustomerPointTransaction::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('CustomerPointTransaction not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}