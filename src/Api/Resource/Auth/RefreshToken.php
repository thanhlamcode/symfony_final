<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Auth;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Auth\RefreshTokenProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/auth/refresh.{_format}',
    openapi: new Operation(
        tags: ['Authentication'],
        summary: 'Refresh JWT token',
        description: 'Refresh the current JWT token'
    ),
    processor: RefreshTokenProcessor::class
)]
final readonly class RefreshToken
{
    public function __construct(
        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'])]
        public string $token,
    ) {
    }
} 