---
description: Tracking with PHP API.
month_change: true
---

# Tracking with PHP API

You can interact directly with the [Raptor connector](raptor_connector.md)'s service using the [PHP API](/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking.html) for advanced tracking usage.

## Advanced usage – direct interaction with the service

### Mapping event data

The recommended method, providing full control over event tracking, is [`EventMapperInterface::map()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Tracking-EventMapperInterface.html#method_map) method.
It allows you to interact directly with the service, supporting advanced use cases not covered by default implementation.

Check the following example:

``` php
[[= include_file('code_samples/recommendations/EventMapper.php') =]]
```

### Manual `EventData` creation

Manual creation of EventData allows precise control over the events sent to the service.
It enables you to define custom event parameters, track specific user interactions, and tailor data collection to advanced use cases.

Check the following example:

``` php
[[= include_file('code_samples/recommendations/EventData.php') =]]
```

`categoryPath` parameter sets the category path for recommendations and needs to be composed manually following the specified format and rules:

- format: `CategoryId#CategoryName;CategoryId#CategoryName`, for example, `25#Electronics;26#Smartphones`
- if `CategoryName` is missing, repeat the ID, for example, `25#25;26#26`
- if `CategoryId` is missing, use the `CategoryName`, for example, `Electronics;Smartphones`

For more information, see available events in the [tracking event namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking-event.html)

### Example - event subscriber

If you need to track [events](../../api/event_reference/event_reference.md) automatically based on application events, you can use Event Subscriber.
It reacts to specific events in the application and triggers tracking logic without the need to add it manually in templates.

``` php
[[= include_file('code_samples/recommendations/EventSubscriber.php') =]]
```

You can also use [[= product_name =]] events, for example `CreateOrderEvent` from [Order management events](../../api/event_reference/order_management_events.md).
For more information, see [Event reference](event_reference.md).
