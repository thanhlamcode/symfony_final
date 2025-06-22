<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\MemberShipLevel;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\MemberShipLevel\CreateMemberShipLevel;
use App\Entity\MemberShipLevel;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateMemberShipLevel> */
class CreateMemberShipLevelProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): MemberShipLevel
    {
        $entity = new MemberShipLevel();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}