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
use Symfony\Component\Uid\UuidV7;
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
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Espresso'])]
        public string $name,

        #[Assert\NotBlank]
        #[Assert\Positive]
        #[ApiProperty(openapiContext: ['example' => 25000])]
        public int $price,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => '/categories/1'])]
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