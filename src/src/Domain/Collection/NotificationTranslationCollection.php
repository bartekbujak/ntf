<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\Exception\NotificationTranslationNotFound;
use App\Domain\ValueObject\Language;
use App\Domain\ValueObject\NotificationTranslation;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<string, NotificationTranslation>
 */
class NotificationTranslationCollection implements IteratorAggregate
{
    /** @var NotificationTranslation[] */
    private array $collection = [];

    public function add(NotificationTranslation $translation): void
    {
        $language = (string) $translation->language;
        $this->collection[$language] = $translation;
    }

    /**
     * @throws NotificationTranslationNotFound
     */
    public function getByPreferredLanguage(Language $language): NotificationTranslation
    {
        $languageAsString = (string) $language;
        if (isset($this->collection[$languageAsString])) {
            return $this->collection[$languageAsString];
        }

        throw new NotificationTranslationNotFound();
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->collection);
    }
}
