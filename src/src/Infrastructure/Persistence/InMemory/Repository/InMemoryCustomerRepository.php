<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory\Repository;

use App\Domain\Collection\CustomerCollection;
use App\Domain\Repository\CustomerRepository;
use App\Domain\ValueObject\CustomerId;

class InMemoryCustomerRepository implements CustomerRepository
{
    public function findManyFromCursor(?CustomerId $cursor, int $limit = 10): CustomerCollection
    {
        return new CustomerCollection();
    }
}
