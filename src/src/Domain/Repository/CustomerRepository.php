<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Collection\CustomerCollection;
use App\Domain\ValueObject\CustomerId;

interface CustomerRepository
{
    public function findManyFromCursor(?CustomerId $cursor, int $limit = 10): CustomerCollection;
}
