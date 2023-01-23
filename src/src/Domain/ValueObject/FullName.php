<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

final class FullName
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName
    ) {}

    public function __toString(): string
    {
        return "$this->firstName $this->lastName";
    }
}
