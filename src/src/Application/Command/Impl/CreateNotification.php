<?php
declare(strict_types=1);

namespace App\Application\Command\Impl;

use App\Application\Dto\NotificationDTO;

class CreateNotification
{
    public function __construct(public readonly NotificationDTO $dto) {}
}
