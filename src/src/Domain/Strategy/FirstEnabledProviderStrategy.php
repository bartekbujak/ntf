<?php
declare(strict_types=1);

namespace App\Domain\Strategy;

use App\Domain\Entity\Customer;
use App\Domain\Service\ChannelProviderCollection;

class FirstEnabledProviderStrategy implements ProviderStrategy
{
    public function getProviders(Customer $customer, ChannelProviderCollection $enabledProviders): ChannelProviderCollection
    {
        $providersForCustomer = [];
        foreach ($enabledProviders as $enabledProvider) {
            if ($enabledProvider->canHandleCustomer($customer)) {
                $providersForCustomer[] = $enabledProvider;
                break;
            }
        }

        return new ChannelProviderCollection($providersForCustomer);
    }
}
