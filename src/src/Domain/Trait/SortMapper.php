<?php

declare(strict_types=1);

namespace App\Domain\Trait;

trait SortMapper
{
    public function sortMapper(): array
    {
        return [
            'createdAt' => 'createdBy.date',
            'updatedAt' => 'updatedBy.date',
        ];
    }

    public function getSort()
    {
        $mapper = $this->sortMapper();
        $sortField = $this->getSortField();
        if (array_key_exists($sortField, $mapper)) {
            return $mapper[$sortField];
        }

        return $sortField;
    }

    public function getSortField(): string
    {
        return $this->sort;
    }
}
