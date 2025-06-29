<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Coupon;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Coupon\UpdateCouponProcessor;
use App\Entity\Coupon;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/coupons/{id}.{_format}',
    openapi: new Operation(
        tags: ['Coupon'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Coupon::class,
    processor: UpdateCouponProcessor::class,
    security: "is_granted('ROLE_ADMIN')"
)]
final readonly class UpdateCoupon
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[ApiProperty(openapiContext: ['example' => 'Summer Sale Coupon'])]
        public ?string $name = null,

        #[ApiProperty(openapiContext: ['example' => 'SUMMER2024'])]
        public ?string $code = null,

        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public ?string $promotionProgram = null,

        #[ApiProperty(openapiContext: ['example' => 'PERCENTAGE'])]
        public ?string $discountType = null,

        #[Assert\Positive]
        #[ApiProperty(openapiContext: ['example' => '10.5'])]
        public ?string $value = null,

        #[Assert\Positive]
        #[ApiProperty(openapiContext: ['example' => '100'])]
        public ?string $quantity = null,

        #[ApiProperty(openapiContext: ['example' => 'ACTIVE'])]
        public ?string $status = null,

        #[Assert\PositiveOrZero]
        #[ApiProperty(openapiContext: ['example' => '50.0'])]
        public ?string $minOrderValue = null,

    ) {
    }
}