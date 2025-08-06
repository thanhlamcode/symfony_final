<?php

declare(strict_types=1);

namespace App\Api\Resource\Staff;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Staff\CreateStaffShiftProcessor;
use App\Entity\StaffShift;
use App\Entity\Staff;
use App\Entity\Shop;
use App\Entity\WorkShift;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/staff_shifts.{_format}',
    openapi: new Operation(tags: ['StaffShift']),
    output: StaffShift::class,
    processor: CreateStaffShiftProcessor::class
)]
final readonly class CreateStaffShift
{
    public function __construct(
        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => '/api/staff/01986f63-9209-7928-87e0-fb39b0487490'])]
        public Staff $staff,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => '/api/shops/01986f63-9209-7928-87e0-fb39b0487490'])]
        public Shop $shop,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => '/api/work_shifts/01986f63-9209-7928-87e0-fb39b0487490'])]
        public WorkShift $workShift,

        #[ApiProperty(openapiContext: ['example' => 'Làm ca sáng'])]
        public ?string $description = null,
    ) {}
}