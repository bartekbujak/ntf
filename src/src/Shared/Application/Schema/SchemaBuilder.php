<?php

declare(strict_types=1);

namespace App\Shared\Application\Schema;

use App\Shared\Application\Attributes\ValidationAttribute;
use JMS\Serializer\Annotation\Type as SerializerType;
use ReflectionClass;
use Symfony\Component\Validator\Constraint;

class SchemaBuilder
{
    public function build(SchemaInterface $schemaDTO)
    {
        $reflectionClass = new ReflectionClass($schemaDTO);
        $properties = $reflectionClass->getProperties();
        $schema = new Schema();
        foreach ($properties as $property) {
            $schemaField = new SchemaField();
            $schemaField->name = $property->getName();

            $attributes = $property->getAttributes();
            if (empty($attributes)) {
                continue;
            }

            foreach ($attributes as $attribute) {
                $attributeInstance = $attribute->newInstance();
                if ($attributeInstance instanceof Constraint || $attributeInstance instanceof SerializerType) {
                    continue;
                }

                if ($attributeInstance instanceof ValidationAttribute) {
                    $schemaField->{$attributeInstance->getKey()}[$attributeInstance->getValidationRuleKey()] = $attributeInstance->getValue();
                } else {
                    $schemaField->{$attributeInstance->getKey()} = $attributeInstance->getValue();
                }
            }
            $schema->addField($schemaField);
        }

        return $schema;
    }
}
