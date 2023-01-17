<?php

declare(strict_types=1);

namespace App\Application\Factory\Admin;

use App\Application\Enum\Resources;
use App\Shared\Application\Command\Impl\RemoveTranslationCommand;
use App\Shared\Application\Command\Impl\TranslateCommand;
use App\Shared\Application\Dto\Translation\TranslateDTO;
use App\Shared\Application\Exception\CannotMatchResourceException;
use App\Shared\Application\Schema\SchemaInterface;

class ResourceFactory
{
    /**
     * @throws CannotMatchResourceException
     */
    public function createRemoveTranslationCommand(string $resource, TranslateDTO $dto): RemoveTranslationCommand
    {
        return match (Resources::tryFrom($resource)) {
//            Resources::NEWS => new RemoveTranslationNewsCommand($dto),
            default => throw new CannotMatchResourceException("resource: ${resource} does not exist"),
        };
    }

    /**
     * @throws CannotMatchResourceException
     */
    public function createTranslateCommand(string $resource, TranslateDTO $dto): TranslateCommand
    {
        return match (Resources::tryFrom($resource)) {
//            Resources::NEWS => new TranslateNewsCommand($dto),
            default => throw new CannotMatchResourceException("resource: ${resource} does not exist"),
        };
    }

    /**
     * @throws CannotMatchResourceException
     */
    public function createDtoForSchema(string $resource, string $type): SchemaInterface
    {
        return match ([Resources::tryFrom($resource), $type]) {
//            [Resources::NEWS, 'create'] => new CreateNewsDTO(),
            default => throw new CannotMatchResourceException("resource:${resource} or type:${type} does not exist"),
        };
    }
}
