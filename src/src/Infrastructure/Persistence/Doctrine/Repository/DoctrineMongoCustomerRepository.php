<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Collection\CustomerCollection;
use App\Domain\Entity\Customer;
use App\Domain\Repository\CustomerRepository;
use App\Domain\ValueObject\CustomerId;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityNotFoundException;

class DoctrineMongoCustomerRepository implements CustomerRepository
{
    public function __construct(private DocumentManager $dm)
    {
    }

    public function findManyFromCursor(?CustomerId $cursor, int $limit = 10): CustomerCollection
    {
        $qb = $this->dm->createQueryBuilder(Customer::class);
        if ($cursor) {
            $qb->field('id')->gt($cursor);
        }
        $qb->limit($limit);
        $result = $qb->getQuery()->execute();
        $collection = new CustomerCollection();
        foreach ($result as $customer) {
            $collection->add($customer);
        }

        return $collection;
    }

    public function findOne(CustomerId $customerId): Customer
    {
        $customer = $this->dm->getRepository(Customer::class)->find($customerId);
        if (!($customer instanceof Customer)) {
            throw new EntityNotFoundException('Customer not found');
        }

        return $customer;
    }
}
