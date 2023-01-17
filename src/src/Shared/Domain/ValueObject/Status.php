<?php

namespace App\Shared\Domain\ValueObject;

enum Status: string
{
    case PUBLISHED = 'published';
    case UNPUBLISHED = 'unpublished';
}
