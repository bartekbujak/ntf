<?php
declare(strict_types=1);

namespace App\Domain\Service;
use App\Domain\Entity\Customer;
use App\Domain\Exception\MessageSendFailedException;

interface ChannelProvider
{
    /**
     * @throws  MessageSendFailedException
     */
    public function sendNotification(Customer $customer, string $message): void;

    public function getName(): string;

    public function canHandleCustomer(Customer $customer): bool;

    public function isEnabled(): bool;
}
