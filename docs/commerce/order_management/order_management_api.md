---
description: Use PHP API to manage orders in Commerce: find, get, create and update them.
edition: commerce
---

# Order management API

!!! tip "Order management REST API"

    To learn how to manage orders with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-orders).

To get orders and manage them, use the `Ibexa\Contracts\OrderManagement\OrderServiceInterface` interface.

## Get single order 

### Get single order by identifier

To access a single order by using its string identifier, use the `OrderService::getOrderByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 46, 50) =]]
```

### Get single order by id

To access a single order by using its numerical id, use the `OrderService::getOrder` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 52, 57) =]]
```

## Get multiple orders

To fetch multiple orders, use the `OrderService::findOrders` method. 
It follows the same search Query pattern as other APIs:

``` php
use Ibexa\Contracts\OrderManagement\Value\OrderQuery;

// ...
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 75, 79) =]]
```

## Create order

To create an order, use the `orderServiceInterface::createOrder` method and provide 
it with the `Ibexa\Contracts\OrderManagement\Value\OrderCreateStruct` that contains a list of products, purchased quantities, product and total prices, as well as tax amounts.

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 59, 66) =]]
```

## Update order

You can update order after the order is created. 
You could do it to support a scenario when, for example, the order is processed manually and its status has to be changed in the system. 
To update order information, use the `OrderServiceInterface::updateOrder` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/OrderCommand.php', 68, 73) =]]
```