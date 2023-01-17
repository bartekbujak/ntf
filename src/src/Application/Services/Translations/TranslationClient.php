<?php

declare(strict_types=1);

namespace App\Application\Services\Translations;

use App\Shared\Application\Dto\Translation\TranslationDTO;

interface TranslationClient
{
    public function translate(TranslationDTO $dto);
}
