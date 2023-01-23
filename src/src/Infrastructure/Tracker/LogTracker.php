<?php
declare(strict_types=1);

namespace App\Infrastructure\Tracker;

use App\Domain\Service\Tracker;
use Psr\Log\LoggerInterface;

class LogTracker implements Tracker
{
    public function __construct(private readonly LoggerInterface $logger) {}
    public function track(string $message, string $providerName, string $customerName): void
    {
        $date = new \DateTimeImmutable();
        $formattedDate = $date->format('Y-m-d H:i:s');
        $this->logger->info("[$formattedDate] Message: $message was sent to $customerName via $providerName");
    }
}
