<?php

declare(strict_types=1);

namespace App\Shared\Domain\Tenant;

final class Tenant
{
    public function __construct(
        public readonly string $shopName,
        public readonly array $languages,
        public readonly string $defaultLanguage,
    ) {
    }
}
