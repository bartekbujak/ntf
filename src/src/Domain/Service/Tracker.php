<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface Tracker
{
    public function track(string $message, string $providerName, string $customerName): void;
}
