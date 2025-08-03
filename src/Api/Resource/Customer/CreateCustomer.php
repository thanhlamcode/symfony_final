<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Customer;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Customer\CreateCustomerProcessor;
use App\Entity\Customer;
use App\Entity\CustomerStatus;
use App\Entity\Gender;
use App\Entity\MemberShipLevel;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/customers.{_format}',
    openapi: new Operation(
        tags: ['Customer'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Customer::class,
    processor: CreateCustomerProcessor::class
)]
final readonly class CreateCustomer
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'John Doe'])]
        public string $name,

        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'john.doe@example.com'])]
        public string $email,

        #[Assert\Length(min: 10, max: 255)]
        #[ApiProperty(openapiContext: ['example' => '+1234567890'])]
        public ?string $phone = null,

        #[Assert\Choice(choices: ['male', 'female', 'other'])]
        #[ApiProperty(openapiContext: ['example' => 'male'])]
        public ?string $gender = null,

        #[ApiProperty(openapiContext: ['example' => '1990-01-01'])]
        public ?\DateTimeInterface $birthday = null,

        #[Assert\Choice(choices: ['active', 'inactive', 'suspended'])]
        #[ApiProperty(openapiContext: ['example' => 'active'])]
        public string $status = 'active',

        #[ApiProperty(openapiContext: ['example' => '123 Main Street'])]
        public ?string $address = null,

        #[ApiProperty(openapiContext: ['example' => '/api/member_ship_levels/01986f63-91cd-7909-8f16-82ae47a93219'])]
        public ?MemberShipLevel $memberShipLevel = null,
    ) {
    }
}
