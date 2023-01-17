<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

use App\Shared\Application\Schema\OptionsStrategyInterface;
use App\Shared\Application\Schema\OptionType;
use Attribute;

#[Attribute]
class Options implements AttributeInterface
{
    private OptionsStrategyInterface $optionStrategy;

    public function __construct(OptionType $optionType)
    {
        $this->optionStrategy = $optionType->getOptionStrategy();
    }

    public function getValue()
    {
        return $this->optionStrategy->getOptions();
    }

    public function getKey(): string
    {
        return 'options';
    }
}
