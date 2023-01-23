<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Language;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class LanguageType extends Type
{
    use ClosureToPHP;

    public function convertToPHPValue(mixed $value): Language
    {
        return new Language($value);
    }

    public function convertToDatabaseValue(mixed $value)
    {
        if (!($value instanceof Language)) {
            throw new \InvalidArgumentException('Argument must be type of Language');
        }

        return (string) $value;
    }
}
