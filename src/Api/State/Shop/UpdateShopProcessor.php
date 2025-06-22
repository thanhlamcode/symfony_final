<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Shop;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Shop\UpdateShop;
use App\Entity\Shop;
use App\Entity\ShopStatus;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateShop> */
class UpdateShopProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Shop
    {
        $shop = $this->entityManager->find(Shop::class, $data->id);
        
        if (!$shop) {
            throw new \InvalidArgumentException('Shop not found');
        }

        if ($data->shopCode !== null) {
            $shop->setShopCode($data->shopCode);
        }
        
        if ($data->name !== null) {
            $shop->setName($data->name);
        }
        
        if ($data->address !== null) {
            $shop->setAddress($data->address);
        }
        
        if ($data->email !== null) {
            $shop->setEmail($data->email);
        }
        
        if ($data->phone !== null) {
            $shop->setPhone($data->phone);
        }
        
        if ($data->avatarUrl !== null) {
            $shop->setAvatarUrl($data->avatarUrl);
        }
        
        if ($data->status !== null) {
            $shop->setStatus(ShopStatus::from($data->status));
        }

        $this->entityManager->flush();

        return $shop;
    }
} 