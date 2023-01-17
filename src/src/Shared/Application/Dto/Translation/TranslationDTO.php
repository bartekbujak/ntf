<?php

declare(strict_types=1);

namespace App\Shared\Application\Dto\Translation;

class TranslationDTO
{
    public function __construct(
        public readonly array $textList,
        public readonly string $sourceLang,
        public readonly string $targetLang,
    ) {
    }
}
