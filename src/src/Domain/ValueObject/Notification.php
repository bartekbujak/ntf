<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Collection\NotificationTranslationCollection;

final class Notification
{
    public function __construct(
        public readonly NotificationTranslationCollection $translationCollection
    ) {}
}
