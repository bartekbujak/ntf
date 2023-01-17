<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

use JMS\Serializer\Annotation as Serializer;

class SchemaField
{
    #[Serializer\SkipWhenEmpty]
    public string $name;

    #[Serializer\SkipWhenEmpty]
    public string $label;

    #[Serializer\SkipWhenEmpty]
    public ?bool $disabled = null;

    #[Serializer\SkipWhenEmpty]
    public ?bool $translatable = null;

    #[Serializer\SkipWhenEmpty]
    public string $type;

    #[Serializer\SkipWhenEmpty]
    public array $options = [];

    #[Serializer\SkipWhenEmpty]
    public array $validation = [];
}
