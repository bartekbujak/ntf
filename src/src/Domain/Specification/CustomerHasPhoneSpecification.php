<?php
declare(strict_types=1);

namespace App\Domain\Specification;
use App\Domain\Entity\Customer;

class CustomerHasPhoneSpecification implements CustomerInfoSpecification
{
    public function isSatisfiedBy(Customer $customer): bool
    {
        if ($customer->phone()) {
            return true;
        }

        return false;
    }
}
