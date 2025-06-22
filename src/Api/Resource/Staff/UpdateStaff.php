<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\Staff;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Staff\UpdateStaffProcessor;
use App\Entity\Staff;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/staff/{id}.{_format}',
    openapi: new Operation(
        tags: ['Staff'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: Staff::class,
    processor: UpdateStaffProcessor::class
)]
final readonly class UpdateStaff
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

        #[Assert\Length(min: 10, max: 20)]
        #[ApiProperty(openapiContext: ['example' => '+1234567890'])]
        public ?string $phone = null,

        #[Assert\Length(max: 100)]
        #[ApiProperty(openapiContext: ['example' => 'Barista'])]
        public ?string $position = null,

        #[ApiProperty(openapiContext: ['example' => true])]
        public ?bool $isActive = null,
    ) {
    }
} 