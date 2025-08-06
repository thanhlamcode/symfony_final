<?php

declare(strict_types=1);

namespace App\Api\Resource\WorkShift;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\WorkShift\UpdateWorkShiftProcessor;
use App\Entity\WorkShift;
use Symfony\Component\Validator\Constraints as Assert;

#[Patch(
    uriTemplate: '/work_shifts/{id}.{_format}',
    openapi: new Operation(tags: ['WorkShift']),
    output: WorkShift::class,
    processor: UpdateWorkShiftProcessor::class
)]
final readonly class UpdateWorkShift
{
    public function __construct(
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Ca sáng'])]
        public ?string $name = null,

        #[ApiProperty(openapiContext: ['example' => 'Làm từ 7h đến 11h'])]
        public ?string $description = null,

        #[ApiProperty(openapiContext: ['example' => '07:00:00'])]
        public ?\DateTimeInterface $startTime = null,

        #[ApiProperty(openapiContext: ['example' => '11:00:00'])]
        public ?\DateTimeInterface $endTime = null,
    ) {}
}