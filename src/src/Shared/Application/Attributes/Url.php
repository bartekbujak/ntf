<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

use Attribute;

#[Attribute]
class Url extends ValidationAttribute
{
    public function __construct()
    {
    }

    public function getValue()
    {
        return null;
    }

    public function getValidationRuleKey(): string
    {
        return 'url';
    }
}
