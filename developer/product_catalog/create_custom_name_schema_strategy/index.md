# Create custom name schema strategy

Create custom name schema strategy to generate URL aliases based on attribute values.

You can create custom name schema strategy to generate URL aliases based on attribute values. Make sure the attributes are configured correctly. Each attribute that you want to include in the URL alias must have a name schema strategy.

## Create converting class

Start by creating a `PercentNameSchemaStrategy` class, which implements `\Ibexa\Contracts\ProductCatalog\NameSchema\NameSchemaStrategyInterface`. This class is responsible for converting attribute values into a string of URL parameters:

```php
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
```

## Register strategy

Next, you need to register the strategy in the dependency injection container:

```yaml
services:
    _defaults:
        public: false
        autowire: true
        autoconfigure: true

    App\Attribute\Percent\PercentNameSchemaStrategy:
        tags:
            - { name: ibexa.product_catalog.naming_schema_strategy }
```

This ensures that the custom name schema strategy is available for use in generating URL aliases based on attribute values.
