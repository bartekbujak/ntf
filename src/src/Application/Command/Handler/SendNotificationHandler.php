<?php
declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\Impl\SendNotificationCommand;
use App\Application\Event\Impl\NotificationFailedEvent;
use App\Application\Event\Impl\NotificationSucceedEvent;
use App\Domain\Exception\NotificationSendFailed;
use App\Domain\Service\ChannelProviderCollection;
use App\Domain\Strategy\ProviderStrategy;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendNotificationHandler
{
    public function __construct(
        private readonly ChannelProviderCollection $providerCollection,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ProviderStrategy $providerStrategy,
    ) {}

    public function __invoke(SendNotificationCommand $command): void
    {
        $notificationTranslation = $command->notification->translationCollection->getByPreferredLanguage(
            $command->customer->preferredLanguage()
        );
        $providers = $this->providerStrategy->getProviders(
            $command->customer,
            $this->providerCollection,
        );
        foreach ($providers as $provider) {
            try {
                $provider->sendNotification($command->customer, $notificationTranslation);
                $this->eventDispatcher->dispatch(new NotificationSucceedEvent());
            } catch (NotificationSendFailed) {
                $this->eventDispatcher->dispatch(new NotificationFailedEvent());
            }
        }
    }
}
