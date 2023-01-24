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
        $customers = [];
        // Create customers with email and phone number
        for ($i = 0; $i < 10; ++$i) {
            $customers[] = new Customer(
                new CustomerId(),
                new FullName('Bartek', 'Bujak'),
                new Language('en'),
                new Email('bartek.bujak94@gmail.com'),
                new PhoneNumber('+48508259291'),
            );
        }
        //customers with empty phone number
        $customers[] = new Customer(
            new CustomerId(),
            new FullName('Bartek', 'Bujak'),
            new Language('en'),
            new Email('bartek.bujak94@gmail.com'),
        );
        //customers with empty email
        $customers[] = new Customer(
            new CustomerId(),
            new FullName('Bartek', 'Bujak'),
            new Language('en'),
            null,
            new PhoneNumber('+48508259291'),
        );
        foreach ($customers as $customer) {
            $manager->persist($customer);
        }
        $manager->flush();
    }
}
