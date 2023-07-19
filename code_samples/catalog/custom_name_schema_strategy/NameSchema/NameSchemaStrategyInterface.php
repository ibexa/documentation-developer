<?php 

declare(strict_types=1);

namespace App\Attribute\NameSchema;

use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionInterface;
use Ibexa\ProductCatalog\NameSchema\NameSchemaStrategyInterface;

final class CustomNameSchemaStrategy implements NameSchemaStrategyInterface
{
    /**
     * @param mixed $value
     */
    public function resolve(AttributeDefinitionInterface $attributeDefinition, $value, string $languageCode): string
    {
        if ($value instanceof CustomValueInterface) {
            return $value->getValue();
        }

        return '';
    }

    /**
     * @param mixed $value
     */
    public function supports(AttributeDefinitionInterface $attributeDefinition, $value): bool
    {
        return $attributeDefinition->getType()->getIdentifier() === 'custom_value';
    }
}
