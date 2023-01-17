<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

enum OptionType: string
{
    case TARGET = 'target';
    case STATUS = 'status';

    public function getOptionStrategy(): OptionsStrategyInterface
    {
        return match ($this) {
            self::TARGET => new TargetOptionsStrategy(),
            self::STATUS => new StatusOptionsStrategy()
        };
    }
}
