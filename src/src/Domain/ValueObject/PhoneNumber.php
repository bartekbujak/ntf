<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final class PhoneNumber
{
    private string $value;

    public function __construct(string $value)
    {
        //todo validate phone
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
