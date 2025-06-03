---
description: Use PHP API and REST API to manage orders in Commerce.
edition: commerce
month_change: true
---

# Order management API

!!! tip "Order management REST API"

    To learn how to manage orders with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#orders).

To get orders and manage them, use the [`Ibexa\Contracts\OrderManagement\OrderServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-OrderServiceInterface.html) interface.

## Get single order

### Get single order by identifier

To access a single order by using its string identifier, use the [`OrderServiceInterface::getOrderByIdentifier`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-OrderServiceInterface.html#method_getOrderByIdentifier) method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 61, 65) =]]
```

### Get single order by ID

To access a single order by using its numerical ID, use the [`OrderServiceInterface::getOrder`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-OrderServiceInterface.html#method_getOrder) method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 67, 72) =]]
```

## Get multiple orders

To fetch multiple orders, use the [`OrderServiceInterface::findOrders`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-OrderServiceInterface.html#method_findOrders) method.
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 8, 9) =]][[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 10, 14) =]]

// ...
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 120, 130) =]]
```

## Create order

To create an order, use the [`OrderServiceInterface::createOrder`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-OrderServiceInterface.html#method_createOrder) method and provide it with the [`Ibexa\Contracts\OrderManagement\Value\Struct\OrderCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-Value-Struct-OrderCreateStruct.html) object that contains a list of products, purchased quantities, product, total prices, and tax amounts.

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 101, 113) =]]
```

## Update order

You can update the order after it's created.
You could do it to support a scenario when, for example, the order is processed manually and its status has to be changed in the system.
To update order information, use the [`OrderServiceInterface::updateOrder`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-OrderServiceInterface.html#method_updateOrder) method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 114, 119) =]]
```
