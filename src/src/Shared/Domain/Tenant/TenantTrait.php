<?php

declare(strict_types=1);

namespace App\Shared\Domain\Tenant;

trait TenantTrait
{
    private string $tenant;

    public function setTenant(string $tenant)
    {
        $this->tenant = $tenant;
    }
}
