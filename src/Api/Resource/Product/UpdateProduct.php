<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Product;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Product\UpdateProductProcessor;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductStatus;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/products/{id}.{_format}',
    openapi: new Operation(
        tags: ['Product'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Product::class,
    processor: UpdateProductProcessor::class
)]
final readonly class UpdateProduct
{
    public function __construct(
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Espresso'])]
        public ?string $name = null,

        #[Assert\Positive]
        #[ApiProperty(openapiContext: ['example' => 25000])]
        public ?int $price = null,

        #[ApiProperty(openapiContext: ['example' => '/categories/1'])]
        public ?Category $category = null,

        #[Assert\Length(max: 1000)]
        #[ApiProperty(openapiContext: ['example' => 'Strong Italian coffee'])]
        public ?string $description = null,

        #[Assert\Url]
        #[ApiProperty(openapiContext: ['example' => 'https://example.com/espresso.jpg'])]
        public ?string $imageUrl = null,

        #[Assert\Choice(choices: ['active', 'inactive', 'out_of_stock'])]
        #[ApiProperty(openapiContext: ['example' => 'active'])]
        public ?string $status = null,
    ) {
    }
}