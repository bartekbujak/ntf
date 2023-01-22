<?php
declare(strict_types=1);

namespace App\Domain\Specification;
use App\Domain\Entity\Customer;

class CustomerHasEmailSpecification implements CustomerInfoSpecification
{
    public function isSatisfiedBy(Customer $customer): bool
    {
        if ($customer->email()) {
            return true;
        }

        return false;
    }
}
