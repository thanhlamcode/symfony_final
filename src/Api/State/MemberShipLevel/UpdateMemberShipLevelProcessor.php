<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\MemberShipLevel;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\MemberShipLevel\UpdateMemberShipLevel;
use App\Entity\MemberShipLevel;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateMemberShipLevel> */
class UpdateMemberShipLevelProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): MemberShipLevel
    {
        $entity = $this->entityManager->find(MemberShipLevel::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('MemberShipLevel not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}