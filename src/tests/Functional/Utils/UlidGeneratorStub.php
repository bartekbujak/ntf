<?php

declare(strict_types=1);

namespace App\Tests\Functional\Utils;

use App\Shared\Domain\Service\UlidGenerator;
use Symfony\Component\Uid\Ulid;

class UlidGeneratorStub extends UlidGenerator
{
    public function __construct(private string $id)
    {
    }

    public function generate(): Ulid
    {
        return new Ulid($this->id);
    }
}
