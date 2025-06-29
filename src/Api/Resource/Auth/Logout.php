<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Auth;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Auth\LogoutProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/auth/logout.{_format}',
    openapi: new Operation(
        tags: ['Authentication'],
        summary: 'User logout',
        description: 'Logout user and invalidate token'
    ),
    processor: LogoutProcessor::class
)]
final readonly class Logout
{
    public function __construct(
        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'])]
        public string $token,
    ) {
    }
} 