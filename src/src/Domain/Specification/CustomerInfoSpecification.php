<?php
declare(strict_types=1);

namespace App\Domain\Specification;

use App\Domain\Entity\Customer;

interface CustomerInfoSpecification
{
    public function isSatisfiedBy(Customer $customer): bool;
}
