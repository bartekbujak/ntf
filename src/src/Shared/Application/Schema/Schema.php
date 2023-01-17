<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

class Schema
{
    /**
     * @var SchemaField[]
     */
    public array $fields = [];

    public function addField(SchemaField $field): void
    {
        $this->fields[] = $field;
    }
}
