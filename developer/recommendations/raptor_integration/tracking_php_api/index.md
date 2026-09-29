# Tracking with PHP API

Tracking with PHP API.

You can interact directly with the [Raptor connector](../raptor_connector/index.md)'s service using the [PHP API](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking.html) for advanced tracking usage.

## Advanced usage – direct interaction with the service

The [`ServerSideTrackingDispatcherInterface::dispatch()`](../../../../../../ibexa/connector-raptor/src/contracts/Tracking/ServerSideTrackingDispatcherInterface.php) method allows sending tracking data from the server side. It can be used in controllers, event subscribers, or any other part of the application. This method receives an [`Ibexa\Contracts\ConnectorRaptor\Tracking\Event\EventDataInterface`](../../../../../../ibexa/connector-raptor/src/contracts/Tracking/Event/EventDataInterface.php). For more information, see the available events in the [tracking event namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking-event.html).

### Mapping event data

The recommended method is [`EventMapperInterface::map()`](../../../../../../ibexa/connector-raptor/src/contracts/Tracking/EventMapperInterface.php). This method receives an [`Ibexa\Contracts\ConnectorRaptor\Tracking\EventType`](../../../../../../ibexa/connector-raptor/src/contracts/Tracking/EventType.php) case, a data depending on the event type (a [`Ibexa\Contracts\ProductCatalog\Values\ProductInterface`](../../../../../../ibexa/product-catalog/src/contracts/Values/ProductInterface.php), a [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php), or a `string`), and a context's associative array that uses [`Ibexa\Contracts\ConnectorRaptor\Tracking\EventContext`](../../../../../../ibexa/connector-raptor/src/contracts/Tracking/EventContext.php) constants as keys.

For more information, see the same arguments of the Twig function [`ibexa_tracking_track_event`](../../../templating/twig_function_reference/recommendations_twig_functions/index.md#ibexa_tracking_track_event-function).

| Event type                 | Data class              | Context keys                                                                                                                                                                          |
| -------------------------- | ----------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `EventType::VISIT`         | `ProductInterface`      | (optional) `EventContext::CATEGORY_IDENTIFIER`, (optional) `EventContext::WEBSITE_ID`                                                                                                 |
| `EventType::CONTENT_VISIT` | `Content`               | (optional) `EventContext::WEBSITE_ID`                                                                                                                                                 |
| `EventType::BUY`           | `ProductInterface`      | `EventContext::SUBTOTAL`, `EventContext::CURRENCY`, `EventContext::QUANTITY`, (optional) `EventContext::CATEGORY_IDENTIFIER`, (optional) `EventContext::WEBSITE_ID`                   |
| `EventType::BASKET`        | `ProductInterface`      | `EventContext::BASKET_CONTENT`, `EventContext::BASKET_ID`, (optional) `EventContext::CATEGORY_IDENTIFIER`, (optional) `EventContext::QUANTITY`, (optional) `EventContext::WEBSITE_ID` |
| `EventType::ITEM_CLICK`    | `string` (product code) | `EventContext::MODULE_NAME`, `EventContext::REDIRECT_URL`                                                                                                                             |
| `EventType::PAGEVIEW`      | `string` (URL)          | `EventContext::URL` (required), (optional) `EventContext::WEBSITE_ID`                                                                                                                 |

Check the following example:

```php
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventContext;
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventMapperInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventType;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
//…

// Map product to VisitEventData automatically, override its category
$eventData = $this->eventMapper->map(EventType::VISIT, $product, [
    EventContext::CATEGORY_IDENTIFIER => 'electronics',
]);

// Send tracking event
$this->trackingDispatcher->dispatch($eventData);
```

### Category parameter for product events

In Ibexa DXP, products can be assigned to multiple categories. However, Raptor accepts only a single category value in tracking events.

By default, the connector uses the first category from the list of categories assigned to the product. You can override this behavior and define which category is sent in tracking events.

To do this:

1. Open the product page in the back office.
2. Check the categories assigned to the product and select the one you want to use.
3. Copy the identifier.
4. Pass this identifier as the category parameter in the tracking event.

> **Note: Note**
>
> This option applies only to product-related tracking events.

Example:

```text
{% block content %}
    <div class="product-details">
        <h1>{{ product.name }}</h1>
        {# ... product content ... #}
    </div>

    {# Track with category identifier - automatic loading and formatting #}
    {{ ibexa_tracking_track_event('visit', product, {
        'categoryIdentifier': 'electronics'
    }) }}
{% endblock %}
```

### Manual `EventData` creation

Manual creation of `EventData` allows precise control over the events sent to the service. It enables you to define custom event parameters, track specific user interactions, and tailor data collection to advanced use cases.

Check the following example:

```php
use Ibexa\Contracts\ConnectorRaptor\Tracking\Event\VisitEventData;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
// …

$eventData = new VisitEventData(
    productCode: $product->getCode(),
    productName: $product->getName(),
    categoryPath: '25#Electronics;26#Smartphones',  // Build manually
    currency: 'USD',
    itemPrice: '999.99'
);

$this->trackingDispatcher->dispatch($eventData);
```

`categoryPath` parameter sets the category path for recommendations and needs to be composed manually following the specified format and rules:

- format: `CategoryId#CategoryName;CategoryId#CategoryName`, for example, `25#Electronics;26#Smartphones`
- if `CategoryName` is missing, repeat the ID, for example, `25#25;26#26`
- if `CategoryId` is missing, use the `CategoryName`, for example, `Electronics;Smartphones`

For more information, see the available events in the [tracking event namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-connectorraptor-tracking-event.html).

### Example - event subscriber

If you need to track [events](../../../api/event_reference/event_reference/index.md) automatically based on application events, you can use an event subscriber. It reacts to specific events in the application and triggers tracking logic without the need to add it manually in templates.

```php
<?php declare(strict_types=1);

namespace App\Tracking;

use Ibexa\Contracts\ConnectorRaptor\Tracking\EventMapperInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventType;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EventMapperInterface $eventMapper,
        private readonly ServerSideTrackingDispatcherInterface $trackingDispatcher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::RESPONSE => ['onResponse', -10]];
    }

    public function onResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        // Example: track only if request has specific attribute
        $product = $request->attributes->get('product');
        if (null === $product) {
            return;
        }

        $eventData = $this->eventMapper->map(EventType::VISIT, $product);
        $this->trackingDispatcher->dispatch($eventData);
    }
}
```

You can also use Ibexa DXP events, for example `CreateOrderEvent` from [Order management events](../../../api/event_reference/order_management_events/index.md). For more information, see [Event reference](../../../api/event_reference/event_reference/index.md).
