# Create custom availability strategy

Implement custom availability strategies to handle different business scenarios, for example pre-orders or per-region availability.

The product catalog uses an availability strategy to calculate [computed availability](../products/index.md#availability-and-computed-availability) for a product. Computed availability decides whether the customers can order the product. The default availability strategy is based on the product availability and stock amount.

You can replace this logic with a custom strategy to handle specific business scenarios, for example preorders, minimum order quantities, or per-region availability.

The following example implements an availability strategy which allows buying products when they're set as available, without taking their stock into account. You could use it for [virtual products](../products/index.md#product-types) or in preorder scenarios.

## Create custom availability context

Use an availability context to pass the parameters needed by the strategy to evaluate computed availability. To do it, create a class that implements the [`Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityContextInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Availability/AvailabilityContextInterface.php) interface:

```php
<?php declare(strict_types=1);

namespace App\ProductCatalog\Availability;

use Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityContextInterface;

final class PurchasableWithoutStockAvailabilityContext implements AvailabilityContextInterface
{
}
```

## Create custom availability strategy

Create a class that implements the [`Ibexa\Contracts\ProductCatalog\ProductAvailabilityStrategyInterface`](../../../../../ibexa/product-catalog/src/contracts/ProductAvailabilityStrategyInterface.php) interface:

```php
<?php declare(strict_types=1);

namespace App\ProductCatalog\Availability;

use Ibexa\Contracts\ProductCatalog\ProductAvailabilityStrategyInterface;
use Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityContextInterface;
use Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityInterface;
use Ibexa\Contracts\ProductCatalog\Values\ProductInterface;
use Ibexa\ProductCatalog\Local\Persistence\Legacy\ProductAvailability\HandlerInterface;
use Ibexa\ProductCatalog\Local\Repository\Values\Availability;

final readonly class ProductAvailabilityPurchasableWithoutStockStrategy implements ProductAvailabilityStrategyInterface
{
    public function __construct(private HandlerInterface $handler)
    {
    }

    public function accept(AvailabilityContextInterface $context): bool
    {
        return $context instanceof PurchasableWithoutStockAvailabilityContext;
    }

    public function getProductAvailability(
        ProductInterface $product,
        AvailabilityContextInterface $context
    ): AvailabilityInterface {
        $productAvailability = $this->handler->find($product->getCode());

        $rawAvailableFlag = $productAvailability->isAvailable();
        $stock = $productAvailability->getStock();
        $isInfinite = $productAvailability->isInfinite();

        $computedAvailable = $this->calculateAvailability(
            $rawAvailableFlag,
            $stock,
            $isInfinite,
        );

        return new Availability(
            $product,
            $rawAvailableFlag,
            $computedAvailable,
            $isInfinite,
            $stock,
        );
    }

    private function calculateAvailability(
        bool $rawAvailable,
        ?int $stock,
        bool $isInfinite
    ): bool {
        if ($rawAvailable === false) {
            return false;
        }

        if ($isInfinite) {
            return true;
        }

        if ($stock === null) {
            return true;
        }

        return $stock >= 0;
    }
}
```

The strategy has two methods:

- `accept()` decides if the strategy can handle the provided availability context
- `getProductAvailability()` returns an [`Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Availability/AvailabilityInterface.php) object

When constructing the `AvailabilityInterface` object, provide the stock amount, the availability flag, and the result of your custom availability logic.

## Register strategy as a service

If you're not using [autowiring](https://symfony.com/doc/7.4/service_container/autowiring.html), tag the strategy service with `ibexa.product_catalog.availability.strategy`:

```yaml
services:
    App\ProductCatalog\Availability\ProductAvailabilityPurchasableWithoutStockStrategy:
        tags:
            - { name: ibexa.product_catalog.availability.strategy }
```

## Use custom context

To evaluate product availability using a custom strategy, pass the custom context as the second argument to [`ProductAvailabilityServiceInterface::getAvailability()`](../../../../../ibexa/product-catalog/src/contracts/ProductAvailabilityServiceInterface.php):

```php

```
