<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

use Attribute;

#[Attribute]
class Disabled implements AttributeInterface
{
    public function __construct(private bool $value)
    {
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function getKey(): string
    {
        return 'disabled';
    }
}
