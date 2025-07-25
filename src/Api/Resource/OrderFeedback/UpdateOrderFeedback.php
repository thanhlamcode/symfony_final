<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\Resource\OrderFeedback;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\OrderFeedback\UpdateOrderFeedbackProcessor;
use App\Entity\OrderFeedback;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\UuidV7;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/orderfeedbacks/{id}.{_format}',
    openapi: new Operation(
        tags: ['OrderFeedback'],
    ),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: OrderFeedback::class,
    processor: UpdateOrderFeedbackProcessor::class
)]
final readonly class UpdateOrderFeedback
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        #[ApiProperty(openapiContext: ['example' => 'd36f7f32-9f20-7e7a-9014-5b79e2bc5671'])]
        public string|UuidV7 $id,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $order = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $rating = null,

        #[ApiProperty(openapiContext: ['example' => 'example'])]
        public ?string $comment = null,

    ) {
    }
}