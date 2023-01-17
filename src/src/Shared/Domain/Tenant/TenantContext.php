<?php

declare(strict_types=1);

namespace App\Shared\Domain\Tenant;

use App\Shared\Domain\Exception\TenantNotSetException;

class TenantContext
{
    private ?Tenant $tenant = null;
    private bool $isInitialized = false;

    public function initialize(Tenant $tenant)
    {
        if ($this->isInitialized) {
            throw new \Exception('Tenant Context already initialized');
        }

        $this->isInitialized = true;
        $this->tenant = $tenant;
    }

    /**
     * @throws TenantNotSetException
     */
    public function getCurrentTenant(): Tenant
    {
        if (is_null($this->tenant)) {
            throw new TenantNotSetException('No tenant yet!');
        }

        return $this->tenant;
    }
}
