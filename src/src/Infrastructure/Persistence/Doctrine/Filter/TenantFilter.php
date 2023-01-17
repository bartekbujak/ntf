<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Filter;

use App\Shared\Domain\Tenant\Tenant;
use App\Shared\Domain\Tenant\TenantAware;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Query\Filter\BsonFilter;

class TenantFilter extends BsonFilter
{
    private ?Tenant $tenant = null;

    public function setTenant(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function addFilterCriteria(ClassMetadata $targetDocument): array
    {
        if (!$this->tenant) {
            return [];
        }
        if (!$targetDocument->reflClass->implementsInterface(TenantAware::class)) {
            return [];
        }

        return ['tenant' => $this->tenant->shopName];
    }
}
