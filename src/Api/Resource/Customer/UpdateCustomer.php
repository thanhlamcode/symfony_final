<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Customer;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Customer\UpdateCustomerProcessor;
use App\Entity\Customer;
use App\Entity\CustomerStatus;
use App\Entity\Gender;
use App\Entity\MemberShipLevel;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/customers/{id}.{_format}',
    openapi: new Operation(
        tags: ['Customer'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Customer::class,
    processor: UpdateCustomerProcessor::class
)]
final readonly class UpdateCustomer
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'John Doe'])]
        public ?string $name = null,

        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'john.doe@example.com'])]
        public ?string $email = null,

        #[Assert\Length(min: 10, max: 255)]
        #[ApiProperty(openapiContext: ['example' => '+1234567890'])]
        public ?string $phone = null,

        #[Assert\Choice(callback: [Gender::class, 'values'])]
        #[ApiProperty(openapiContext: ['example' => 'male'])]
        public ?string $gender = null,

        #[ApiProperty(openapiContext: ['example' => '1990-01-01'])]
        public ?\DateTimeInterface $birthday = null,

        #[Assert\Choice(callback: [CustomerStatus::class, 'values'])]
        #[ApiProperty(openapiContext: ['example' => 'active'])]
        public ?string $status = null,

        #[ApiProperty(openapiContext: ['example' => '123 Main Street'])]
        public ?string $address = null,

        #[ApiProperty(openapiContext: ['example' => '/member_ship_levels/1'])]
        public ?MemberShipLevel $memberShipLevel = null,
    ) {
    }
} 