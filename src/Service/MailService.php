<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Gửi email.
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string|null $from
     * @return void
     */
    public function sendMail(string $to, string $subject, string $body, ?string $from = null): void
    {
        $email = (new Email())
            ->to($to)
            ->subject($subject)
            ->html($body);

        if ($from) {
            $email->from($from);
        }

        $this->mailer->send($email);
    }
} 