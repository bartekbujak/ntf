<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider\Mailgun;

use App\Domain\ValueObject\Email;
use Mailgun\Mailgun;
use Psr\Http\Client\ClientExceptionInterface;

class MailgunClient
{
    private Mailgun $mgClient;

    public function __construct(
        private readonly string $domain,
        string $apiKey
    ) {
        $this->mgClient = Mailgun::create($apiKey);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function sendEmail(Email $email, string $message): void
    {
        $this->mgClient->messages()->send($this->domain, [
            'from' => 'noreply@'.$this->domain,
            'to' => (string) $email,
            'subject' => 'Notification',
            'text' => $message,
        ]);
    }
}
