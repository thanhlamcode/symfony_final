<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\MemberShipLevel;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\MemberShipLevel\UpdateMemberShipLevelProcessor;
use App\Entity\MemberShipLevel;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/membershiplevels/{id}.{_format}',
    openapi: new Operation(
        tags: ['MemberShipLevel'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: MemberShipLevel::class,
    processor: UpdateMemberShipLevelProcessor::class
)]
final readonly class UpdateMemberShipLevel
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $name = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $description = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $type = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $discountPercentage = null,

    ) {
    }
}