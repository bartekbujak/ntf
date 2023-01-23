<?php
declare(strict_types=1);

namespace App\Infrastructure\Provider\Twilio;

use App\Domain\ValueObject\PhoneNumber;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioClient
{
    private Client $client;

    public function __construct(
        string $sid,
        string $token,
        private readonly string $twilioPhone,
    )
    {
        $this->client = new Client($sid, $token);
    }

    /**
     * @throws TwilioException
     */
    public function sendTextMessage(PhoneNumber $phoneNumber, string $message): void
    {
        $this->client->messages->create(
            (string) $phoneNumber,
            [
                'from' => $this->twilioPhone,
                'body' => $message,
            ]
        );
    }
}
