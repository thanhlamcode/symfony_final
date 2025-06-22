<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\ShopSetting;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\ShopSetting\CreateShopSettingProcessor;
use App\Entity\ShopSetting;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/shopsettings.{_format}',
    openapi: new Operation(
        tags: ['ShopSetting'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: ShopSetting::class,
    processor: CreateShopSettingProcessor::class
)]
final readonly class CreateShopSetting
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $shop = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $openTime = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $closeTime = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $workingDays = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $avatarUrl = null,

    ) {
    }
}