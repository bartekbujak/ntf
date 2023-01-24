<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\ValueObject\Email;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class EmailType extends Type
{
    use ClosureToPHP;

    public function convertToPHPValue(mixed $value): Email
    {
        return new Email($value);
    }

    public function convertToDatabaseValue(mixed $value)
    {
        if (!($value instanceof Email)) {
            throw new \InvalidArgumentException('Argument must be type of Email');
        }

        return (string) $value;
    }
}
