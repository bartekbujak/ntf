<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

use Attribute;

#[Attribute]
class MaxLength extends ValidationAttribute
{
    public function __construct(private int $value)
    {
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getValidationRuleKey(): string
    {
        return 'maxLength';
    }
}
