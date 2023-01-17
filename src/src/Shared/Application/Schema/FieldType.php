<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

enum FieldType: string
{
    case TEXT = 'text';
    case URL = 'url';
    case RTE = 'rte';
    case IMAGE = 'image';
    case SELECT = 'select';
    case DATETIME = 'dateTime';
    case LABEL = 'label';
    case LABELDATETIME = 'labelDateTime';
    case CUSTOM = 'custom';
}
