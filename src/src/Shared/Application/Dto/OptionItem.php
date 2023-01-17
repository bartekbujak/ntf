<?php

declare(strict_types=1);

namespace App\Shared\Application\Dto;

class OptionItem
{
    public function __construct(public string $value, public string $label)
    {
    }
}
