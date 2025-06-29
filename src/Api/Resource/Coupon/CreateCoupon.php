<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Coupon;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Coupon\CreateCouponProcessor;
use App\Entity\Coupon;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/coupons.{_format}',
    openapi: new Operation(
        tags: ['Coupon'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Coupon::class,
    processor: CreateCouponProcessor::class,
    security: "is_granted('ROLE_ADMIN')"
)]
final readonly class CreateCoupon
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => 'Summer Sale Coupon'])]
        public ?string $name = null,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => 'SUMMER2024'])]
        public ?string $code = null,

        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public ?string $promotionProgram = null,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => 'PERCENTAGE'])]
        public ?string $discountType = null,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[ApiProperty(openapiContext: ['example' => '10.5'])]
        public ?string $value = null,

        #[Assert\NotBlank]
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