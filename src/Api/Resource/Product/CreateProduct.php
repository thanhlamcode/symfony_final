<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Product;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Product\CreateProductProcessor;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductStatus;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/products.{_format}',
    openapi: new Operation(
        tags: ['Product'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Product::class,
    processor: CreateProductProcessor::class
)]
final readonly class CreateProduct
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Espresso'])]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[ApiProperty(openapiContext: ['example' => 25000])]
        public int $price,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => '/api/categories/01986f63-9209-7928-87e0-fb39b0487490'])]
        public Category $category,

        #[Assert\Length(max: 1000)]
        #[ApiProperty(openapiContext: ['example' => 'Strong Italian coffee'])]
        public ?string $description = null,

        #[Assert\Url]
        #[ApiProperty(openapiContext: ['example' => 'https://example.com/espresso.jpg'])]
        public ?string $imageUrl = null,

        #[Assert\Choice(choices: ['active', 'inactive', 'out_of_stock'])]
        #[ApiProperty(openapiContext: ['example' => 'active'])]
        public string $status = 'active',
    ) {
    }
}
