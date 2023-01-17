<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use DateTime;

class Maintainer
{
    public function __construct(private string $name, private DateTime $date = new DateTime('now'))
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }
}
