<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Shop;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Shop\CreateShop;
use App\Entity\Shop;
use App\Entity\ShopStatus;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateShop> */
class CreateShopProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Shop
    {
        $shop = new Shop();

        $shop->setId($data->id);
        $shop->setShopCode($data->shopCode);
        $shop->setName($data->name);
        $shop->setAddress($data->address);
        $shop->setEmail($data->email);
        $shop->setPhone($data->phone);
        $shop->setAvatarUrl($data->avatarUrl);
        $shop->setStatus(ShopStatus::from($data->status));

        $this->entityManager->persist($shop);
        $this->entityManager->flush();

        return $shop;
    }
} 