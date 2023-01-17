<?php

declare(strict_types=1);

namespace App\Shared\Application\Dto\Translation;

use JMS\Serializer\Annotation\Type;

class TranslationResponseDTO
{
    /**
     * @Type("array")
     */
    public array $translations;
}
