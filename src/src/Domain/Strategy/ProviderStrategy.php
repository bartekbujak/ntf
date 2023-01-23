<?php
declare(strict_types=1);

namespace App\Domain\Strategy;

use App\Domain\Entity\Customer;
use App\Domain\Service\ChannelProviderCollection;
use App\Domain\ValueObject\NotificationTranslation;

interface ProviderStrategy
{
    public function execute(
        Customer $customer,
        NotificationTranslation $notificationTranslation,
        ChannelProviderCollection $providersForCustomer
    ): void;
}
