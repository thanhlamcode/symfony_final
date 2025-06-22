<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\ShopSetting;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\ShopSetting\CreateShopSetting;
use App\Entity\ShopSetting;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateShopSetting> */
class CreateShopSettingProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ShopSetting
    {
        $entity = new ShopSetting();

        // Set properties here
        $entity->setId($data->id);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity;
    }
}