<?php

declare(strict_types=1);

namespace App\Shared\Application\Attributes;

interface AttributeInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    public function getKey(): string;
}
