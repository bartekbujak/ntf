<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

final class NotificationTranslation
{
    public function __construct(
        public readonly Language $language,
        private readonly string $content
    ) {}

    public function __toString(): string
    {
        return $this->content;
    }
}
