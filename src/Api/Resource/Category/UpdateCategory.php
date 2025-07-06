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
    input: UpdateCategory::class,
    output: Category::class,
    processor: UpdateCategoryProcessor::class
)]
final readonly class UpdateCategory
{
    public function __construct(
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
