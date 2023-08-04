---
description: Create custom name schema strategy to generate URL aliases based on attribute values.
---

# Create custom name schema strategy

You can create custom name schema strategy to generate URL aliases based on attribute values.

Make sure the attributes are configured correctly. 
Each attribute that you want to include in the URL alias must have a name schema strategy.

## Create converting class

Start by creating a `PercentNameSchemaStrategy` class, which implements `\Ibexa\Contracts\ProductCatalog\NameSchema\NameSchemaStrategyInterface`. 
This class is responsible for converting attribute values into a string of URL parameters:

``` php
[[= include_file('code_samples/catalog/percent_name_schema_strategy/NameSchema/PercentNameSchemaStrategy.php') =]]
```

## Register strategy

Next, you need to register the strategy in the dependency injection container:

``` yaml
[[= include_file('code_samples/catalog/percent_name_schema_strategy/src/bundle/Resources/config/services/name_schema.yaml') =]]
```

This ensures that the custom name schema strategy is available for use in generating URL aliases based on attribute values.