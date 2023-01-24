<?php

declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\Impl\SendNotificationCommand;
use App\Domain\Exception\NotificationTranslationNotFound;
use App\Domain\Repository\CustomerRepository;
use App\Domain\Service\ChannelProviderCollection;
use App\Domain\Strategy\ProviderStrategy;

class SendNotificationHandler
{
    public function __construct(
        private readonly ProviderStrategy $providerStrategy,
        private readonly ChannelProviderCollection $enabledProviders,
        private readonly CustomerRepository $customerRepository,
    ) {
    }

    public function __invoke(SendNotificationCommand $command): void
    {
        $customer = $this->customerRepository->findOne($command->customerId);

        try {
            $notificationTranslation = $command->notification->translationCollection->getByPreferredLanguage(
                $customer->preferredLanguage()
            );
        } catch (NotificationTranslationNotFound) {
            return;
            // Skip notification, other solutions: get different language, translate using translator to preferred language.
        }
        $providersForCustomer = $this->enabledProviders->createCollectionForCustomer($customer);
        $this->providerStrategy->execute(
            $customer,
            $notificationTranslation,
            $providersForCustomer
        );
    }
}
