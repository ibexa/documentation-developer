---
description: Tracking with PHP API.
month_change: true
---

# Tracking with PHP API

You can interact directly with the [Raptor connector](raptor_connector.md)'s service using the [PHP API](/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking.html) for advanced tracking usage.

## Advanced usage – direct interaction with the service

The [`ServerSideTrackingDispatcherInterface::dispatch()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Tracking-ServerSideTrackingDispatcherInterface.html#method_dispatch) method allows to send tracking data from the server side.
It can be used in controllers, event subscribers, or any other part of the application.
This method receives an [`EventDataInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Tracking-Event-EventDataInterface.html).
For more information, see the available events in the [tracking event namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking-event.html).

### Mapping event data

The recommended method is [`EventMapperInterface::map()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Tracking-EventMapperInterface.html#method_map).
This method receives an [`EventType`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Tracking-EventType.html#cases) case, a data depending on the event type (a [`ProductInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html), a [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html), or a `string`), and a context's associative array that uses [`EventContext`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Tracking-EventContext.html) constants as keys.

For more information, see the same arguments of the Twig function [`ibexa_tracking_track_event`](recommendations_twig_functions.md#ibexa_tracking_track_event-function).

| Event type                 | Data class              | Context keys                                                                                                                                                                                      |
|:---------------------------|:------------------------|:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `EventType::VISIT`         | `ProductInterface`      | (optional) `EventContext::CATEGORY_IDENTIFIER`,<br>(optional) `EventContext::WEBSITE_ID`                                                                                                          |
| `EventType::CONTENT_VISIT` | `Content`               | (optional) `EventContext::WEBSITE_ID`                                                                                                                                                             |
| `EventType::BUY`           | `ProductInterface`      | `EventContext::SUBTOTAL`,<br>`EventContext::CURRENCY`,<br>`EventContext::QUANTITY`,<br>(optional) `EventContext::CATEGORY_IDENTIFIER`,<br>(optional) `EventContext::WEBSITE_ID`                   |
| `EventType::BASKET`        | `ProductInterface`      | `EventContext::BASKET_CONTENT`,<br>`EventContext::BASKET_ID`,<br>(optional) `EventContext::CATEGORY_IDENTIFIER`,<br>(optional) `EventContext::QUANTITY`,<br>(optional) `EventContext::WEBSITE_ID` |
| `EventType::ITEM_CLICK`    | `string` (product code) | `EventContext::MODULE_NAME`,<br>`EventContext::REDIRECT_URL`                                                                                                                                      |

Check the following example:

``` php
[[= include_file('code_samples/recommendations/EventMapper.php', 4, 8) =]]//…

[[= include_file('code_samples/recommendations/EventMapper.php', 20, 27, remove_indent=True) =]]
```

### Manual `EventData` creation

Manual creation of EventData allows precise control over the events sent to the service.
It enables you to define custom event parameters, track specific user interactions, and tailor data collection to advanced use cases.

Check the following example:

``` php
[[= include_file('code_samples/recommendations/EventData.php', 4, 6) =]]// …

[[= include_file('code_samples/recommendations/EventData.php', 17, 26, remove_indent=True) =]]
```

`categoryPath` parameter sets the category path for recommendations and needs to be composed manually following the specified format and rules:

- format: `CategoryId#CategoryName;CategoryId#CategoryName`, for example, `25#Electronics;26#Smartphones`
- if `CategoryName` is missing, repeat the ID, for example, `25#25;26#26`
- if `CategoryId` is missing, use the `CategoryName`, for example, `Electronics;Smartphones`

For more information, see the available events in the [tracking event namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking-event.html).

### Example - event subscriber

If you need to track [events](event_reference.md) automatically based on application events, you can use an event subscriber.
It reacts to specific events in the application and triggers tracking logic without the need to add it manually in templates.

``` php
[[= include_file('code_samples/recommendations/EventSubscriber.php') =]]
```

You can also use [[= product_name =]] events, for example `CreateOrderEvent` from [Order management events](order_management_events.md).
For more information, see [Event reference](event_reference.md).
