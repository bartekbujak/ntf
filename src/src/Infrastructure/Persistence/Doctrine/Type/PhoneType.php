<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\PhoneNumber;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class PhoneType extends Type
{
    use ClosureToPHP;

    public function convertToPHPValue(mixed $value): PhoneNumber
    {
        return new PhoneNumber($value);
    }

    public function convertToDatabaseValue(mixed $value)
    {
        if (!($value instanceof PhoneNumber)) {
            throw new \InvalidArgumentException('Argument must be type of PhoneNumber');
        }

        return (string) $value;
    }
}
