<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Category;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Category\UpdateCategoryProcessor;
use App\Entity\Category;
use App\Entity\CategoryStatus;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/categories/{id}.{_format}',
    openapi: new Operation(
        tags: ['Category'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Category::class,
    processor: UpdateCategoryProcessor::class
)]
final readonly class UpdateCategory
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Coffee'])]
        public ?string $name = null,

        #[Assert\Length(max: 500)]
        #[ApiProperty(openapiContext: ['example' => 'All types of coffee products'])]
        public ?string $description = null,

        #[Assert\Choice(choices: ['active', 'inactive'])]
        #[ApiProperty(openapiContext: ['example' => 'active'])]
        public ?string $status = null,
    ) {
    }
}