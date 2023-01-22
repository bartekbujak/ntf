<?php
declare(strict_types=1);

namespace App\Application\Dto;

use App\Domain\ValueObject\Language;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type as SerializerType;

class NotificationDTO
{
    #[Assert\Type('array')]
    #[SerializerType('array')]
    #[OA\Property(type: 'array', items: new OA\Items(), example: '[{""en"":""Message""}, {""lt"":""Pranešimas""}]')]
    public array $contentCollection = []; //@TODO add validation

    public function getByLanguage(Language $language): string
    {
        foreach ($this->contentCollection as $key => $content) {
            if ($key === (string) $language) {
                return $content;
            }
        }
        return $this->contentCollection[0];
    }
}
