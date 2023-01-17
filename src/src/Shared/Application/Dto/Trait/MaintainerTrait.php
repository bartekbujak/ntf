<?php

declare(strict_types=1);

namespace App\Shared\Application\Dto\Trait;

use App\Shared\Application\Attributes\Label;
use App\Shared\Application\Attributes\Type;
use App\Shared\Application\Schema\FieldType;

trait MaintainerTrait
{
    #[Label('Created By')]
    #[Type(FieldType::LABEL)]
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    public string $createdBy;

    #[Label('Created At')]
    #[Type(FieldType::LABELDATETIME)]
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    public string $createdAt;

    #[Label('Updated By')]
    #[Type(FieldType::LABEL)]
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    public string $updatedBy;

    #[Label('Updated At')]
    #[Type(FieldType::LABELDATETIME)]
    /**
     * @OA\Property(type="string", maxLength=255)
     */
    public string $updatedAt;
}
