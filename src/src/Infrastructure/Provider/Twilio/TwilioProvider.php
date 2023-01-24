<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider\Twilio;

use App\Domain\Entity\Customer;
use App\Domain\Exception\NotificationSendFailed;
use App\Domain\Service\ChannelProvider;
use App\Domain\ValueObject\NotificationTranslation;
use Psr\Log\LoggerInterface;
use Twilio\Exceptions\TwilioException;

class TwilioProvider implements ChannelProvider
{
    public const PROVIDER_NAME = 'Twilio';

    public function __construct(
        private readonly TwilioClient $client,
        private readonly LoggerInterface $logger,
        private readonly bool $isEnabled,
    ) {
    }

    public function sendNotification(Customer $customer, NotificationTranslation $notification): void
    {
        try {
            $this->client->sendTextMessage($customer->phone(), (string) $notification);
        } catch (TwilioException $e) {
            $this->logger->error($e->getMessage());

            throw new NotificationSendFailed();
        }
    }

    public function getName(): string
    {
        return self::PROVIDER_NAME;
    }

    public function canHandleCustomer(Customer $customer): bool
    {
        if ($customer->phone()) {
            return true;
        }

        return false;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }
}
