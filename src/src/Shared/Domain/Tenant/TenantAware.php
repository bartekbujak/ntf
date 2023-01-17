<?php

declare(strict_types=1);

namespace App\Shared\Domain\Tenant;

interface TenantAware
{
    public function setTenant(string $tenant);
}
