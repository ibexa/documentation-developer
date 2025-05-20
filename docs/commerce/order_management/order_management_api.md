---
description: Use PHP API and REST API to manage orders in Commerce.
edition: commerce
---

# Order management API

!!! tip "Order management REST API"

    To learn how to manage orders with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#orders).

To get orders and manage them, use the `Ibexa\Contracts\OrderManagement\OrderServiceInterface` interface.

## Get single order

### Get single order by identifier

To access a single order by using its string identifier, use the `OrderService::getOrderByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 61, 65) =]]
```

### Get single order by ID

To access a single order by using its numerical ID, use the `OrderService::getOrder` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 68, 72) =]]
```

## Get multiple orders

To fetch multiple orders, use the `OrderService::findOrders` method.
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 8, 9) =]][[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 10, 14) =]]

// ...
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 120, 130) =]]
```

## Create order

To create an order, use the `OrderService::createOrder` method and provide it with the `Ibexa\Contracts\OrderManagement\Value\OrderCreateStruct` object that contains a list of products, purchased quantities, product, total prices, and tax amounts.

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 101, 113) =]]
```

## Update order

You can update the order after it's created.
You could do it to support a scenario when, for example, the order is processed manually and its status has to be changed in the system.
To update order information, use the `OrderService::updateOrder` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 114, 119) =]]
```
