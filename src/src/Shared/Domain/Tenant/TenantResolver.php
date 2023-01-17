<?php

declare(strict_types=1);

namespace App\Shared\Domain\Tenant;

class TenantResolver
{
    private array $tenants;

    public function __construct(array $shops)
    {
        foreach ($shops as $shopName => $shop) {
            $this->tenants[$shopName] = new Tenant($shopName, $shop['languages'], $shop['defaultLanguage']);
        }
    }

    public function findByShopName(string $shopName = null): Tenant
    {
        if (null === $shopName || !isset($this->tenants[$shopName])) {
            /* Fallback to first shop */
            return reset($this->tenants);
        }

        return $this->tenants[$shopName];
    }
}
