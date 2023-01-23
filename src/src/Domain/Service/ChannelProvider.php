<?php
declare(strict_types=1);

namespace App\Domain\Service;
use App\Domain\Entity\Customer;
use App\Domain\Exception\NotificationSendFailed;
use App\Domain\ValueObject\NotificationTranslation;

interface ChannelProvider
{
    /**
     * @throws  NotificationSendFailed
     */
    public function sendNotification(Customer $customer, NotificationTranslation $notification): void;

    public function getName(): string;

    public function canHandleCustomer(Customer $customer): bool;

    public function isEnabled(): bool;
}
