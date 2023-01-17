<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;

use Symfony\Component\Uid\Uuid;

class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::v6()->generate();
    }
}
