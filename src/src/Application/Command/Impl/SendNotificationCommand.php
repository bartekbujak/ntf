<?php
declare(strict_types=1);

namespace App\Application\Command\Impl;

use App\Domain\ValueObject\CustomerId;
use App\Domain\ValueObject\Notification;

class SendNotificationCommand
{
    public function __construct(
        public readonly Notification $notification,
        public readonly CustomerId $customerId,
    ) {}
}
