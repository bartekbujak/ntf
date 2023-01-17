<?php

declare(strict_types=1);

namespace App\Shared\Application\Command\Impl;

use App\Shared\Application\Dto\Translation\TranslateDTO;

abstract class TranslateCommand
{
    public function __construct(public readonly TranslateDTO $dto)
    {
    }
}
