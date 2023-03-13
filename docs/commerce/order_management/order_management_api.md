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
        $order = $this->getOrderByIdentifier('4ac4b8a0-eed8-496d-87d9-32a960a10629');

        $output->writeln($order->getName());
```

## Get single order by id

To access a single order by using its numerical id, use the `OrderService::getOrder` method:

``` php
        $order = $this->getOrder(2);

        $output->writeln($order->getName());
```

## Get multiple orders

To fetch multiple orders, use the `OrderService::findOrders` method. 
It fsollows the same earch Query pattern as other APIs:

``` php
use Ibexa\Contracts\OrderManagement\Value\OrderQuery;

// ...

        $orderQuery = new OrderQuery();
        $orderQuery->setSource('local_shop'); // orders that originate from a source called 'local_shop' 
        $orderQuery->setLimit(20); // fetch 20 orders

        $ordersList = $this->orderService->findOrders($orderQuery);

        $ordersList->getOrders(); // array of OrderInterface objects
        $ordersList->getTotalCount(); // number of returned orders
```

## Create order

To create an order, use the `orderServiceInterface::createOrder` method and provide 
it with the `Ibexa\Contracts\OrderManagement\Value\OrderCreateStruct` that contains a list of products, purchased quantities, product and total prices, as well as tax amounts.

``` php
// snippet
```

## Update order

You can update order after the order is created. 
You could do it to support a scenario when, for example, the order is processed manually and its status has to be changed in the system. 
To update order information, use the `OrderServiceInterface::updateOrder` method:

``` php
// snippet
```