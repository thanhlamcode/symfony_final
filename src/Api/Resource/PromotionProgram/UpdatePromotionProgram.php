<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\PromotionProgram;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\PromotionProgram\UpdatePromotionProgramProcessor;
use App\Entity\PromotionProgram;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/promotionprograms/{id}.{_format}',
    openapi: new Operation(
        tags: ['PromotionProgram'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: PromotionProgram::class,
    processor: UpdatePromotionProgramProcessor::class
)]
final readonly class UpdatePromotionProgram
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
        public ?string $startDate = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $endDate = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $status = null,

    ) {
    }
}