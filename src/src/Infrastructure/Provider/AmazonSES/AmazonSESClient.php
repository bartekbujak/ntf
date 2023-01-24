<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider\AmazonSES;

use App\Domain\ValueObject\Email;
use Aws\Exception\AwsException;
use Aws\Ses\SesClient;

class AmazonSESClient
{
    private readonly SesClient $sesClient;

    public function __construct()
    {
        $this->sesClient = new SesClient([
            'profile' => 'default',
            'version' => '2010-12-01',
            'region' => 'us-east-2',
        ]);
    }

    /**
     * @throws AwsException
     */
    public function sendEmail(Email $email, string $message): void
    {
        $sender_email = 'noreply@notification.example.com';

        $this->sesClient->sendEmail([
            'Destination' => [
                'ToAddresses' => [(string) $email],
            ],
            'ReplyToAddresses' => [$sender_email],
            'Source' => $sender_email,
            'Message' => [
                'Body' => [
                    'Html' => [
                        'Charset' => 'UTF-8',
                        'Data' => $message,
                    ],
                    'Text' => [
                        'Charset' => 'UTF-8',
                        'Data' => $message,
                    ],
                ],
                'Subject' => [
                    'Charset' => 'UTF-8',
                    'Data' => 'New notification',
                ],
            ],
        ]);
    }
}
