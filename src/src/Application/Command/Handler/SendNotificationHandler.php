<?php
declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\Impl\SendNotificationCommand;
use App\Domain\Exception\MessageSendFailedException;
use App\Domain\Service\ChannelProviderCollection;
use App\Domain\Service\Tracker;
use App\Domain\Strategy\MultipleProviderStrategy;

class SendNotificationHandler
{
    public function __construct(
        private readonly ChannelProviderCollection $providerCollection,
        private readonly Tracker $tracker,
    ) {}

    public function __invoke(SendNotificationCommand $command): void
    {
        $message = $command->dto->getByLanguage($command->customer->preferredLanguage());
        $providers = $this->providerCollection->getProvidersForCustomer(
            $command->customer,
            new MultipleProviderStrategy()
        );
        $failedProviders = [];
        foreach ($providers as $provider) {
            try {
                $provider->sendNotification($command->customer, $message);
                $this->tracker->track($message, $provider->getName(), 'customerName');
            } catch (MessageSendFailedException) {
                $failedProviders = $provider;
            }
        }
    }
}
