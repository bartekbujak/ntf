<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

use App\Shared\Application\Dto\OptionItem;

interface OptionsStrategyInterface
{
    /**
     * @return OptionItem[]
     */
    public function getOptions(): array;
}
