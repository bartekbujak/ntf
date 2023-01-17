<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

use App\Shared\Application\Dto\OptionItem;

class StatusOptionsStrategy implements OptionsStrategyInterface
{
    /**
     * @return OptionItem[]
     */
    public function getOptions(): array
    {
        $options = [];
        //default options
        $options[] = new OptionItem('unpublished', 'Unpublished');
        $options[] = new OptionItem('published', 'Published');

        //additional options (categories)

        return $options;
    }
}
