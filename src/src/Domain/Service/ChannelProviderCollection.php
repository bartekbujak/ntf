<?php
declare(strict_types=1);

namespace App\Domain\Service;
use App\Domain\Entity\Customer;
use App\Domain\Strategy\ProviderStrategy;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, ChannelProvider>
 */
class ChannelProviderCollection implements IteratorAggregate
{
    /** @var ChannelProvider[] */
    private array $collection = [];

    public function __construct(iterable $providers)
    {

        foreach ($providers as $provider) {
            if (!($provider instanceof ChannelProvider)) {
                throw new \InvalidArgumentException('Provider must implement: '. ChannelProvider::class);
            }
            if ($provider->isEnabled()) {
                $this->collection[] = $provider;
            }
        }
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->collection);
    }

    public function getProvidersForCustomer(Customer $customer, ProviderStrategy $strategy): ChannelProviderCollection
    {
        return $strategy->getProviders($customer, $this);
    }
}
