<?php
declare(strict_types=1);

namespace App\Application\Command\Impl;

use App\Application\Dto\NotificationDTO;
use App\Domain\ValueObject\CustomerId;

class BatchNotificationCommand
{
    public function __construct(
        public readonly NotificationDTO $dto,
        public readonly ?CustomerId $cursor = null,
    ) {}
}
