<?php

declare(strict_types=1);

namespace App\Application\Dto;

use OpenApi\Attributes as OA;

class NotificationTranslationDTO
{
    #[OA\Property(type: 'string', example: 'en')]
    public string $language;

    #[OA\Property(type: 'string', example: 'notification')]
    public string $content;
}
