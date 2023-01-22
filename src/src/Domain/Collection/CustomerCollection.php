<?php
declare(strict_types=1);

namespace App\Domain\Collection;
use App\Domain\Entity\Customer;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, Customer>
 */
class CustomerCollection implements IteratorAggregate
{
    /** @var Customer[] */
    private array $collection = [];

    public function add(Customer $customer): void
    {
        $this->collection[] = $customer;
    }

    public function last(): Customer
    {
        return $this->collection[array_key_last($this->collection)];
    }


    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->collection);
    }
}
