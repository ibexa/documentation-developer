---
description: Tracking with PHP API.
month_change: true
---

# Tracking with PHP API

You can interact directly with the [Raptor connector](raptor_connector.md)'s service using the [PHP API](/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking.html) for advanced tracking usage.

## Advanced usage – direct interaction with the service

### `EventMapper`'s method

The recommended method, providing full control over event tracking, is [`EventMapperInterface::map()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorRaptor-Tracking-EventMapperInterface.html#method_map) method.
It allows to interact directly with the service, supporting advanced use cases not covered by default implementation.

Check the following example:

``` php
[[= include_file('code_samples/recommendations/EventMapper.php') =]]
```

### Manual `EventData` creation

Manual creation of EventData allows precise control over the events sent to the service.
It enables to define custom event parameters, track specific user interactions, and tailor data collection to advanced use cases.

Check the following example:

``` php
[[= include_file('code_samples/recommendations/EventData.php') =]]
```

For more information, see available events in the [tracking event namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking-event.html)

### Example - event subscriber

If you need to track events automatically based on application events, you can use Event Subscriber.
It reacts to specific events in the application and triggers tracking logic without the need to add it manually in templates.

``` php
[[= include_file('code_samples/recommendations/EventSubscriber.php') =]]
```
