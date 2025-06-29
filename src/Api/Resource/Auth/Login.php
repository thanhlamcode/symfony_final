<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Auth;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Auth\LoginProcessor;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/auth/login.{_format}',
    openapi: new Operation(
        tags: ['Authentication'],
        summary: 'User login',
        description: 'Authenticate user and return JWT token'
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    processor: LoginProcessor::class
)]
final readonly class Login
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'user@example.com'])]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 3)]
        #[ApiProperty(openapiContext: ['example' => 'password123'])]
        public string $password,
    ) {
    }
}
