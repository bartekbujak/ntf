<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Exception\TranslationNotFoundException;
use Doctrine\Common\Collections\Collection;

interface TranslationAware
{
    /**
     * @throws TranslationNotFoundException
     */
    public function getTranslation(string $locale): mixed;

    public function getTranslations(): Collection;
}
