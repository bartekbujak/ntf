<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

use App\Shared\Application\Dto\OptionItem;

class TargetOptionsStrategy implements OptionsStrategyInterface
{
    public const ALL = 'all';
    public const NONE = 'none';

    /**
     * @return OptionItem[]
     */
    public function getOptions(): array
    {
        $options = [];
        //default options
        $options[] = new OptionItem(self::ALL, 'All');
        $options[] = new OptionItem(self::NONE, 'None');

        //additional options (categories)

        return $options;
    }
}
