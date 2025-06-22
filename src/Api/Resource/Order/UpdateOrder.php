<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Order;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Order\UpdateOrderProcessor;
use App\Entity\Order;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/orders/{id}.{_format}',
    openapi: new Operation(
        tags: ['Order'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Order::class,
    processor: UpdateOrderProcessor::class
)]
final readonly class UpdateOrder
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $customer = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $shop = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $staff = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $totalAmount = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $paymentMethod = null,

    ) {
    }
}