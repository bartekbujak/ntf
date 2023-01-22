<?php
declare(strict_types=1);

namespace App\Application\Command\Impl;

use App\Application\Dto\NotificationDTO;
use App\Domain\Entity\Customer;

class SendNotificationCommand
{
    public function __construct(
        public readonly NotificationDTO $dto,
        public readonly Customer $customer,
    ) {}
}
