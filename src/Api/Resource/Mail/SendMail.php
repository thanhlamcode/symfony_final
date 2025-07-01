<?php

declare(strict_types=1);

namespace App\Api\Resource\Mail;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use App\Api\State\Mail\SendMailProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[Post(
    uriTemplate: '/mail/send.{_format}',
    openapi: new Operation(
        tags: ['Mail'],
        summary: 'Send a test email',
        description: 'Send a test email to the given address.'
    ),
    processor: SendMailProcessor::class
)]
final readonly class SendMail
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'user@example.com'])]
        public string $to,

        #[Assert\NotBlank]
        #[ApiProperty(openapiContext: ['example' => 'Test subject'])]
        public string $subject,

        #[ApiProperty(openapiContext: ['example' => '<b>This is a test email.</b>'])]
        public ?string $body = null,
    ) {
    }
} 