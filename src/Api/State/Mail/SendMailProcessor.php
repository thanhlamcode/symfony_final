<?php

declare(strict_types=1);

namespace App\Api\State\Mail;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Mail\SendMail;
use App\Service\MailService;

class SendMailProcessor implements ProcessorInterface
{
    private MailService $mailService;
    private const DEFAULT_FROM = 'lamdoan1122334455@gmail.com';

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @param SendMail $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SendMail
    {
        $this->mailService->sendMail(
            $data->to,
            $data->subject,
            $data->body ?? '<b>This is a test email.</b>',
            self::DEFAULT_FROM
        );
        return $data;
    }
} 