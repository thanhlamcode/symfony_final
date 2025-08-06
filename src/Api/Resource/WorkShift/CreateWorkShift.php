<?php

declare(strict_types=1);

namespace App\Api\Resource\WorkShift;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\WorkShift\CreateWorkShiftProcessor;
use App\Entity\WorkShift;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/work_shifts.{_format}',
    openapi: new Operation(tags: ['WorkShift']),
    output: WorkShift::class,
    processor: CreateWorkShiftProcessor::class
)]
final readonly class CreateWorkShift
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 2, max: 255)]
        #[ApiProperty(openapiContext: ['example' => 'Ca sáng'])]
        public string $name,

        #[ApiProperty(openapiContext: ['example' => 'Làm từ 7h đến 11h'])]
        public ?string $description = null,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => '07:00:00'])]
        public \DateTimeInterface $startTime,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => '11:00:00'])]
        public \DateTimeInterface $endTime,
    ) {}
}