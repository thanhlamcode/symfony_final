<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Auth;

use ApiPlatform\Metadata\Get;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Auth\MeProvider;
use App\Entity\User;

#[Get(
    uriTemplate: '/auth/me.{_format}',
    openapi: new Operation(
        tags: ['Authentication'],
        summary: 'Get current user info',
        description: 'Get information about the currently authenticated user'
    ),
    provider: MeProvider::class,
    security: "is_granted('ROLE_USER')"
)]
final readonly class Me
{
    public function __construct(
        public User $user
    ) {
    }
} 