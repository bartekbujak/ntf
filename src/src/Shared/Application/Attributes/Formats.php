<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

use Attribute;

#[Attribute]
class Formats extends ValidationAttribute
{
    public function __construct(private array $value)
    {
    }

    public function getValue(): array
    {
        return $this->value;
    }

    public function getValidationRuleKey(): string
    {
        return 'formats';
    }
}
