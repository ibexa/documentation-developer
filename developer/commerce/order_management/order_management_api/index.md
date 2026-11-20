# Order management API

Use PHP API and REST API to manage orders in Commerce.

Editions: Commerce

> **Tip: Order management REST API**
>
> To learn how to manage orders with the REST API, see the [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Orders).

To get orders and manage them, use the [`Ibexa\Contracts\OrderManagement\OrderServiceInterface`](../../../../../../ibexa/order-management/src/contracts/OrderServiceInterface.php) interface.

## Get single order

### Get single order by identifier

To access a single order by using its string identifier, use the [`OrderServiceInterface::getOrderByIdentifier`](../../../../../../ibexa/order-management/src/contracts/OrderServiceInterface.php) method:

```php
$orderIdentifier = '2e897b31-0d7a-46d3-ba45-4eb65fe02790';
$order = $this->orderService->getOrderByIdentifier($orderIdentifier);

$output->writeln(sprintf('Order %s has status %s', $orderIdentifier, $order->getStatus()));
```

Use the returned [`Ibexa\Contracts\OrderManagement\Value\Order\OrderInterface`](../../../../../../ibexa/order-management/src/contracts/Value/Order/OrderInterface.php) value object to access details about the order.

See the [Discounts API](../../../discounts/discounts_api/index.md#retrieve-applied-discounts) to learn how to retrieve applied discount details from the order's context.

### Get single order by ID

To access a single order by using its numerical ID, use the [`OrderServiceInterface::getOrder`](../../../../../../ibexa/order-management/src/contracts/OrderServiceInterface.php) method:

```php
$orderId = 1;
$order = $this->orderService->getOrder($orderId);

$output->writeln(sprintf('Order %d has status %s', $orderId, $order->getStatus()));
```

## Get multiple orders

To fetch multiple orders, use the [`OrderServiceInterface::findOrders`](../../../../../../ibexa/order-management/src/contracts/OrderServiceInterface.php) method. It follows the same search query pattern as other APIs:

```php
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\LogicalOr;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CompanyNameCriterion;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CustomerNameCriterion;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\IdentifierCriterion;


// ...
        $orderCriterions = [
            new IdentifierCriterion('c328773e-8daa-4465-86d5-4d7890f3aa86'),
            new CompanyNameCriterion('IBM'),
            new CustomerNameCriterion('foo_user'),
        ];
        $orderQuery = new OrderQuery(new LogicalOr(...$orderCriterions));
        $orders = $this->orderService->findOrders($orderQuery);

        $output->writeln(sprintf('Found %d orders with provided criteria', count($orders)));
```

## Create order

To create an order, use the [`OrderServiceInterface::createOrder`](../../../../../../ibexa/order-management/src/contracts/OrderServiceInterface.php) method and provide it with the [`Ibexa\Contracts\OrderManagement\Value\Struct\OrderCreateStruct`](../../../../../../ibexa/order-management/src/contracts/Value/Struct/OrderCreateStruct.php) object that contains a list of products, purchased quantities, product, total prices, and tax amounts.

```php
$orderCreateStruct = new OrderCreateStruct(
    $user,
    $currency,
    $value,
    'local_shop',
    $items
);

$order = $this->orderService->createOrder($orderCreateStruct);

$output->writeln(sprintf('Created order with identifier %s', $order->getIdentifier()));
```

## Update order

You can update the order after it's created. You could do it to support a scenario when, for example, the order is processed manually and its status has to be changed in the system. To update order information, use the [`OrderServiceInterface::updateOrder`](../../../../../../ibexa/order-management/src/contracts/OrderServiceInterface.php) method:

```php
$orderUpdateStruct = new OrderUpdateStruct('processed');
$this->orderService->updateOrder($order, $orderUpdateStruct);

$output->writeln(sprintf('Changed order status to %s', $order->getStatus()));
```
