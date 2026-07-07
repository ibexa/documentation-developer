---
description: Implement custom availability strategies to handle different business scenarios, for example pre-orders or per-region availability.
month_change: false
---

# Create custom availability strategy

The product catalog uses an availability strategy to calculate [computed availability](products.md#availability-and-computed-availability) for a product.
Computed availability decides whether the customers can order the product.
The default availability strategy is based on the product availability and stock amount.

You can replace this logic with a custom strategy to handle specific business scenarios, for example preorders, minimum order quantities, or per-region availability.

The following example implements an availability strategy which allows buying products when they're set as available, without taking their stock into account.
You could use it for [virtual products](products.md#product-types) or in preorder scenarios.

## Create custom availability context

Use an availability context to pass the parameters needed by the strategy to evaluate computed availability.
To do it, create a class that implements the [`AvailabilityContextInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-AvailabilityContextInterface.html) interface:

``` php
[[= include_file('code_samples/pim/availability/src/PurchasableWithoutStockAvailabilityContext.php') =]]
```

## Create custom availability strategy

Create a class that implements the [`ProductAvailabilityStrategyInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductAvailabilityStrategyInterface.html) interface:

``` php
[[= include_file('code_samples/pim/availability/src/ProductAvailabilityPurchasableWithoutStockStrategy.php') =]]
```

The strategy has two methods:

- `accept()` decides if the strategy can handle the provided availability context
- `getProductAvailability()` returns an [`AvailabilityInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-AvailabilityInterface.html) object

When constructing the `AvailabilityInterface` object, provide the stock amount, the availability flag, and the result of your custom availability logic.

## Register strategy as a service

If you're not using [autowiring]([[= symfony_doc =]]/service_container/autowiring.html), tag the strategy service with `ibexa.product_catalog.availability.strategy`:

``` yaml
[[= include_file('code_samples/pim/availability/config/custom_services.yaml') =]]
```

## Use custom context

To evaluate product availability using a custom strategy, pass the custom context as the second argument to [`ProductAvailabilityServiceInterface::getAvailability()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductAvailabilityServiceInterface.html):

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 122, 127, remove_indent=True) =]]
```
