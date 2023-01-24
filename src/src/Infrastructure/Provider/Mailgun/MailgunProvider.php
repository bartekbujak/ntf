<?php

declare(strict_types=1);

namespace App\Infrastructure\Provider\Mailgun;

use App\Domain\Entity\Customer;
use App\Domain\Exception\NotificationSendFailed;
use App\Domain\Service\ChannelProvider;
use App\Domain\ValueObject\NotificationTranslation;
use Mailgun\Exception\HttpServerException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Log\LoggerInterface;

class MailgunProvider implements ChannelProvider
{
    public const PROVIDER_NAME = 'Mailgun';

    public function __construct(
        private readonly MailgunClient $client,
        private readonly LoggerInterface $logger,
        private readonly bool $isEnabled,
    ) {
    }

    public function sendNotification(Customer $customer, NotificationTranslation $notification): void
    {
        try {
            $this->client->sendEmail($customer->email(), (string) $notification);
        } catch (ClientExceptionInterface|HttpServerException $e) {
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
        if ($customer->email()) {
            return true;
        }

        return false;
    }

    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }
}
