<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

use Attribute;

#[Attribute]
class Label implements AttributeInterface
{
    public function __construct(private string $value)
    {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getKey(): string
    {
        return 'label';
    }
}
