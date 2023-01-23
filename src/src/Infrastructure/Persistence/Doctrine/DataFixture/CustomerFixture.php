<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\DataFixture;

use App\Domain\Entity\Customer;
use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FullName;
use App\Domain\ValueObject\Language;
use App\Domain\ValueObject\PhoneNumber;
use Doctrine\Bundle\MongoDBBundle\Fixture\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $customer = new Customer(
            new CustomerId(),
            new FullName('Bartek', 'Bujak'),
            new Language('en'),
            new Email('bartek.bujak94+1@gmail.com'),
            new PhoneNumber('508 259 291'),
        );
        $manager->persist($customer);
        $manager->flush();
        // TODO: Implement load() method.
    }
}
