<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;
use App\Domain\ValueObject\CustomerId;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class CustomerIdType extends Type
{
    use ClosureToPHP;

    public function convertToPHPValue(mixed $value): CustomerId
    {
        return new CustomerId($value);
    }

    public function convertToDatabaseValue(mixed $value)
    {
        return $value;
    }
}
