<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Shop;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Shop\CreateShopProcessor;
use App\Entity\Shop;
use App\Entity\ShopStatus;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/shops.{_format}',
    openapi: new Operation(
        tags: ['Shop'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Shop::class,
    processor: CreateShopProcessor::class
)]
final readonly class CreateShop
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[ApiProperty(openapiContext: ['example' => 1001])]
        public int $shopCode,

        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Coffee Shop Downtown'])]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Length(min: 5, max: 255)]
        #[ApiProperty(openapiContext: ['example' => '123 Main Street, Downtown'])]
        public string $address,

        #[Assert\NotBlank]
        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'shop@example.com'])]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 10, max: 255)]
        #[ApiProperty(openapiContext: ['example' => '+1234567890'])]
        public string $phone,

        #[Assert\Url]
        #[ApiProperty(openapiContext: ['example' => 'https://example.com/avatar.jpg'])]
        public ?string $avatarUrl = null,

        #[Assert\Choice(choices: ['active', 'inactive', 'suspended'])]
        #[ApiProperty(openapiContext: ['example' => 'active'])]
        public string $status = 'active',
    ) {
    }
} 