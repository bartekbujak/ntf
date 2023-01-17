<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;

use Symfony\Component\Uid\Ulid;

class UlidGenerator
{
    public function generate(): Ulid
    {
        return new Ulid();
    }
}
