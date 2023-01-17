<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

use App\Shared\Application\Schema\FieldType;
use Attribute;

#[Attribute]
class Type implements AttributeInterface
{
    public function __construct(protected FieldType $fieldType)
    {
    }

    public function getValue(): string
    {
        return $this->fieldType->value;
    }

    public function getKey(): string
    {
        return 'type';
    }
}
