---
description: 
---

# Create custom availability strategy

The product catalog uses an availability strategy to calculate [computed availability](products.md#availability-and-computed-availability) for a product.
The default strategy determines whether a product can be ordered based on its stored availability and stock.

You can replace this logic with a custom strategy to handle specific business scenarios, for example preoders, minimum order quantities, or per-region availability.

The following example implements an availability strategy which allows buying products when they're set as available, without taking their stock into account.
You could use it for [virtual products](products.md#product-types) or in preorder scenarios.

## Create a custom availability context

An availability context carries the parameters needed by the strategy to evaluate computed availability.
Create a class implementing [`AvailabilityContextInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-AvailabilityContextInterface.html):

``` php
[[= include_file('code_samples/pim/availability/src/PurchasableWithoutStockAvailabilityContext.php') =]]
```

## Create a custom availability strategy

Create a class implementing [`ProductAvailabilityStrategyInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductAvailabilityStrategyInterface.html):

``` php
[[= include_file('code_samples/pim/availability/src/ProductAvailabilityPurchasableWithoutStockStrategy.php') =]]
```

The strategy has two methods:

- `accept()` decides if the strategy can handle the provided availability context
- `getProductAvailability()` returns an [`AvailabilityInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-AvailabilityInterface.html) object

When constructing the `AvailabilityInterface` object, provide the stock amount, the availability flag, and the result of your custom availability logic.

## Register the strategy as a service

Tag the strategy service with `ibexa.product_catalog.availability.strategy`:

``` yaml
[[= include_file('code_samples/pim/availability/config/custom_services.yaml') =]]
```

## Use the custom context

Pass the custom context as the second argument to [`ProductAvailabilityServiceInterface::getAvailability()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductAvailabilityServiceInterface.html):

```php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 122, 127, remove_indent=True) =]]
```
