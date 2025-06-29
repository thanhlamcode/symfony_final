<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Auth;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Auth\RegisterProcessor;
use App\Entity\User;
use App\Validator\Constraints\PasswordConfirmation;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/auth/register.{_format}',
    openapi: new Operation(
        tags: ['Authentication'],
        summary: 'User registration',
        description: 'Register a new user account'
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: false,
    processor: RegisterProcessor::class
)]
#[PasswordConfirmation]
final readonly class Register
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'user@example.com'])]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'password123'])]
        public string $password,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'password123'])]
        public string $confirmPassword,
    ) {
    }
}
