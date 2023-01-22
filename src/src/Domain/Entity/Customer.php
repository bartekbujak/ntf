<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\PushyDeviceToken;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Language;
use App\Domain\ValueObject\PhoneNumber;

class Customer
{
    public function __construct(
        public readonly CustomerId $id,
        private Language           $preferredLanguage,
        private ?Email             $email = null,
        private ?PhoneNumber       $phone = null,
        private ?PushyDeviceToken  $pushyDeviceToken = null,
    ) {}

    public function preferredLanguage(): Language
    {
        return $this->preferredLanguage;
    }

    public function email(): ?Email
    {
        return $this->email;
    }

    public function phone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function pushyDeviceToken(): ?PushyDeviceToken
    {
        return $this->pushyDeviceToken;
    }
}
