<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\PromotionProgram;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\PromotionProgram\UpdatePromotionProgram;
use App\Entity\PromotionProgram;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdatePromotionProgram> */
class UpdatePromotionProgramProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): PromotionProgram
    {
        $entity = $this->entityManager->find(PromotionProgram::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('PromotionProgram not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}