<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\ShopSetting;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\ShopSetting\UpdateShopSetting;
use App\Entity\ShopSetting;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateShopSetting> */
class UpdateShopSettingProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ShopSetting
    {
        $entity = $this->entityManager->find(ShopSetting::class, $data->id);
        
        if (!$entity) {
            throw new \InvalidArgumentException('ShopSetting not found');
        }

        // Update properties here

        $this->entityManager->flush();

        return $entity;
    }
}