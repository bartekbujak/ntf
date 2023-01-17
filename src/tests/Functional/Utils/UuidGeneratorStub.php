<?php

declare(strict_types=1);

namespace App\Tests\Functional\Utils;

use App\Shared\Domain\Service\UuidGeneratorInterface;

class UuidGeneratorStub implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return 'test-token';
    }
}
