<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\PromotionProgram;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\PromotionProgram\CreatePromotionProgram;
use App\Entity\PromotionProgram;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreatePromotionProgram> */
class CreatePromotionProgramProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): PromotionProgram
    {
        $entity = new PromotionProgram();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}