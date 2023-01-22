<?php
declare(strict_types=1);

namespace App\Domain\Strategy;

use App\Domain\Entity\Customer;
use App\Domain\Service\ChannelProviderCollection;

interface ProviderStrategy
{
    public function getProviders(Customer $customer, ChannelProviderCollection $enabledProviders): ChannelProviderCollection;
}
