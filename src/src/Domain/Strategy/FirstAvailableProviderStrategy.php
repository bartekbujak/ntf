<?php
declare(strict_types=1);

namespace App\Domain\Strategy;

use App\Domain\Entity\Customer;
use App\Domain\Exception\NotificationSendFailed;
use App\Domain\Service\ChannelProviderCollection;
use App\Domain\ValueObject\NotificationTranslation;
use Psr\Log\LoggerInterface;

class FirstAvailableProviderStrategy implements ProviderStrategy
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ){}

    public function execute(
        Customer $customer,
        NotificationTranslation $notificationTranslation,
        ChannelProviderCollection $providersForCustomer
    ): void
    {
        foreach ($providersForCustomer as $provider) {
            try {
                $provider->sendNotification($customer, $notificationTranslation);
                return;
            } catch (NotificationSendFailed) {
                $this->logger->error('Provider not available' . $provider->getName());
                continue;
            }
        }
    }
}
