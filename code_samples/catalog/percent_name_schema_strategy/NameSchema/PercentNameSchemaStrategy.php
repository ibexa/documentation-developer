<?php declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Contracts\ProductCatalog\NameSchema\NameSchemaStrategyInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionInterface;

final class PercentNameSchemaStrategy implements NameSchemaStrategyInterface
{
    public function resolve(AttributeDefinitionInterface $attributeDefinition, $value, string $languageCode): string
    {
        return ($value * 100) . '%';
    }

    public function supports(AttributeDefinitionInterface $attributeDefinition, $value): bool
    {
        return $attributeDefinition->getType()->getIdentifier() === 'percent';
    }
}
