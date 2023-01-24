<?php

declare(strict_types=1);

namespace App\Application\Dto;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;


class NotificationTranslationDTO
{
    #[Assert\NotBlank]
    #[OA\Property(type: 'string', example: 'en')]
    public string $language;

    #[Assert\NotBlank]
    #[OA\Property(type: 'string', example: 'notification')]
    public string $content;
}
