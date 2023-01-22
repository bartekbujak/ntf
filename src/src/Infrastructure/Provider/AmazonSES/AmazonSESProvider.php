<?php
declare(strict_types=1);

namespace App\Infrastructure\Provider\AmazonSES;

use App\Domain\Entity\Customer;
use App\Domain\Exception\MessageSendFailedException;
use App\Domain\Service\ChannelProvider;
use Aws\Exception\AwsException;
use Psr\Log\LoggerInterface;

class AmazonSESProvider implements ChannelProvider
{
    public function __construct(
        private readonly AmazonSESClient $client,
        private readonly LoggerInterface $logger,
        private readonly bool $isEnabled,
    ) {}
    public function sendNotification(Customer $customer, string $message): void
    {
        try {
            $this->client->sendEmail($customer->email(), $message);
        } catch (AwsException $e) {
            $this->logger->error($e->getAwsErrorMessage());

            throw new MessageSendFailedException();
        }
    }

    public function getName(): string
    {
        return 'Amazon SES';
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