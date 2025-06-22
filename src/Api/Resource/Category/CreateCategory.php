<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Category;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Category\CreateCategoryProcessor;
use App\Entity\Category;
use App\Entity\CategoryStatus;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/categories.{_format}',
    openapi: new Operation(
        tags: ['Category'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Category::class,
    processor: CreateCategoryProcessor::class
)]
final readonly class CreateCategory
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Coffee'])]
        public string $name,

        #[Assert\Length(max: 500)]
        #[ApiProperty(openapiContext: ['example' => 'All types of coffee products'])]
        public ?string $description = null,

        #[Assert\Choice(choices: ['active', 'inactive'])]
        #[ApiProperty(openapiContext: ['example' => 'active'])]
        public string $status = 'active',
    ) {
    }
}