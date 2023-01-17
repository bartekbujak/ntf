<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

abstract class ValidationAttribute implements AttributeInterface
{
    public function getKey(): string
    {
        return 'validation';
    }

    abstract public function getValidationRuleKey(): string;
}
