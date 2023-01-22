<?php
declare(strict_types=1);

namespace App\Domain\Factory;
use App\Domain\Entity\Customer;
use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\PushyDeviceToken;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Language;
use App\Domain\ValueObject\PhoneNumber;

class CustomerFactory
{
    public function create(
        Language          $language,
        ?Email            $email = null,
        ?PhoneNumber      $phone = null,
        ?PushyDeviceToken $token = null,
    ): Customer {
        return new Customer(
            new CustomerId(),
            $language,
            $email,
            $phone,
            $token,
        );
    }
}
