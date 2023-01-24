<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\FullName;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class FullNameType extends Type
{
    use ClosureToPHP;

    public function convertToPHPValue(mixed $value): FullName
    {
        [$firstName, $lastName] = explode(' ', $value);

        return new FullName($firstName, $lastName);
    }

    public function convertToDatabaseValue(mixed $value)
    {
        if (!($value instanceof FullName)) {
            throw new \InvalidArgumentException('Argument must be type of FullName');
        }

        return (string) $value;
    }
}
