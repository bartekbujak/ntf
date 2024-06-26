<?php

declare(strict_types=1);

namespace App\Application\Dto;

use App\Domain\Collection\NotificationTranslationCollection;
use App\Domain\ValueObject\Language;
use App\Domain\ValueObject\Notification;
use App\Domain\ValueObject\NotificationTranslation;
use JMS\Serializer\Annotation\Type as SerializerType;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;


class NotificationDTO
{
    /**
     * @var NotificationTranslationDTO[]
     * @OA\Property(type="array", @OA\Items(ref=@Model(type=NotificationTranslationDTO::class)))
     * @SerializerType("array<App\Application\Dto\NotificationTranslationDTO>")
     * @Assert\All({
     *    @Assert\Type("App\Application\Dto\NotificationTranslationDTO")
     * })
     * @Assert\Count(min=1)
     * @Assert\Valid
     */
    public array $translations = [];

    public function toValueObject(): Notification
    {
        $collection = new NotificationTranslationCollection();
        foreach ($this->translations as $translation) {
            $collection->add(
                new NotificationTranslation(
                    new Language($translation->language),
                    $translation->content
                )
            );
        }

        return new Notification($collection);
    }
}
