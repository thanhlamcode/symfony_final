<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\OrderItem;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\OrderItem\CreateOrderItemProcessor;
use App\Entity\OrderItem;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/orderitems.{_format}',
    openapi: new Operation(
        tags: ['OrderItem'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: OrderItem::class,
    processor: CreateOrderItemProcessor::class
)]
final readonly class CreateOrderItem
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $order = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $product = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $priceProduct = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $productName = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $quantity = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $totalPrice = null,

    ) {
    }
}