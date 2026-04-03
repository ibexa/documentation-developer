---
description: Raptor tracking function.
---

# Raptor tracking function

Raptor [tracking function](https://content.raptorservices.com/help-center/introduction-to-tracking-documentation) introduces visit tracking functionality for collecting user interactions with products and content.
The implementation includes product visit tracking with mapping to tracking parameters, as well as Twig functions for straightforward integration.

## Initialize Raptor tracking script

First, initialize the `ibexa_tracking_script()` tracking script in your base layout template, typically within the <head> section or before the closing <body> tag:

``` html+twig
{# templates/base.html.twig #}
<!DOCTYPE html>
<html>
<head>
    {# ... other head content ... #}

    {# Initialize Raptor tracking - must be called before any tracking events #}
    {{ ibexa_tracking_script() }}
</head>
<body>
    {# ... page content ... #}
</body>
</html>
```

## Tracking parameters

Tracking is handled through twig function that accept following parameters:

``` html+twig
ibexa_tracking_track_event(
    eventType,     {# string: 'visit', 'contentvisit', 'buy', 'basket', 'itemclick' #}
    data,          {# mixed: product, content, or null (optional) #}
    context,       {# array: additional context data (optional) #}
    template       {# string: custom template path (optional) #}
)
```

- **eventType** - type: string, defines the type of tracking event to be sent, for example, `visit`, `contentvisit`, `buy`, `basket`, `itemclick`
- **data** (optional) - type: mixed, accepts the primary object associated with the event, such as a Product or Content, can be null if not required
- **context** (optional)- type: array, additional event data, such as quantity, basket details, or custom parameters
- **template** (optional) - type: string, path to a custom Twig template used to render the tracking event, allows overriding the default tracking output

### `context` parameter - example usage

You can use `context` parameter to add additional data.

During tracking, for products assigned to multiple categories, the system uses the first category.
In this case, `context` parameter allows to override the product category by passing a category identifier:

``` html+twig
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

## Tracking modes

Tracking user interactions can be implemented on the client-side or the server-side.
Each approach differs in where events are captured and how they are sent to the tracking backend.
The `ibexa_tracking_track_event()` function works based on `tracking_type` configuration.

The tracking function outputs different content depending on the mode:

``` yaml
# Server-side tracking
connector_raptor:
    tracking_type: 'server'  # Returns HTML comments

# Client-side tracking
connector_raptor:
    tracking_type: 'client'  # Returns <script> tags
```

- **server** - returns HTML comments, placeholders that do not perform any action. Instead, the tracking is done server-side.
- **client** - returns `script` tags to load the tracking script in the browser.

You can switch tracking mode anytime by changing the `tracking_type` parameter.

For more information on Tracking modes, see Raptor documentation:

- [Client-side tracking](https://content.raptorservices.com/help-center/client-side-tracking)
- [Server-side tracking](https://content.raptorservices.com/help-center/server-side-tracking)
- [Client-side vs. Server-side tracking](https://content.raptorservices.com/help-center/client-side-vs.-server-side-tracking)

## Advanced usage – direct interaction with the service

### `EventMapper` method

The recommended method, providing full control over event tracking, is `EventMapper` method.
It allows to interact directly with the service, supporting advanced use cases not covered by default implementation.

Check the following example:

``` php
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventMapperInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventType;

class MyCustomService
{
    public function __construct(
        private readonly EventMapperInterface $eventMapper,
        private ServerSideTrackingDispatcherInterface $trackingDispatcher,
    ) {}

    public function trackProductView(ProductInterface $product, string $url): void
    {
        // Map product to VisitEventData automatically
        $eventData = $this->eventMapper->map(EventType::VISIT, $product);

        // Send tracking event
        $this->trackingDispatcher->dispatch($eventData);
    }
}
```

### Manual `EventData` creation

Manual creation of EventData allows precise control over the events sent to the service.
It enables to define custom event parameters, track specific user interactions, and tailor data collection to advanced use cases.

Check the following example:

``` php
use Ibexa\Contracts\ConnectorRaptor\Tracking\Event\VisitEventData;

$eventData = new VisitEventData(
    productId: $product->getCode(),
    productName: $product->getName(),
    categoryPath: '25#Electronics;26#Smartphones',  // Build manually
    currency: 'USD',
    itemPrice: '999.99'
);

$this->trackingDispatcher->dispatch($eventData);
```

### Example - event subscriber

If you need to track events automatically based on application events, you can use Event Subscriber.
It reacts to specific events in the application and triggers tracking logic without the need to add it manually in templates.

Example:

``` php
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventMapperInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProductViewTrackingSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EventMapperInterface $eventMapper,
        private ServerSideTrackingDispatcherInterface $trackingDispatcher,
    ) {}

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
        if (!$product) {
            return;
        }

        $eventData = $this->eventMapper->map(EventType::VISIT, $product);
        $this->trackingDispatcher->dispatch($eventData);
    }
}
```

## Tracking events

The following events are supported and can be triggered from Twig templates:

### Product `visit` event

This event tracks product page visits by users.
It's the most common e-commerce tracking event used to capture product views for analytics, recommendation models, and user behavior processing.

Required data:

- **Product object** - defines the product being tracked. It implements `ProductInterface` so the system can read its information (for example, ID, price, category).

Example:

``` html+twig
{# templates/product/view.html.twig #}
{% extends 'base.html.twig' %}

{% block content %}
    <div class="product-details">
        <h1>{{ product.name }}</h1>
        <p>{{ product.description }}</p>
        <div class="price">{{ product.price }}</div>
    </div>

    {# Track product visit #}
    {{ ibexa_tracking_track_event('visit', product) }}
{% endblock %}
```

### Content `visit` event

This event tracks content page visits by users.
It can used to check content views for analytics, personalization, and user behavior tracking.

- **Content object** - defines the content being tracked.

### Basket event

This event tracks when a product is added to the shopping basket.
It catches user interest and helps with conversion tracking and product recommendations.

Required data:

- **Product object** - defines the product being added to the basket.
- **Context array with basket information** - provides optional data about the basket, like quantity or basket ID, to provide context for the event.

Example:

``` html+twig
{# templates/cart/add_confirmation.html.twig #}
{% extends 'base.html.twig' %}

{% block content %}
    <div class="cart-notification">
        <p>Product "{{ product.name }}" has been added to your cart!</p>
        <p>Quantity: {{ addedQuantity }}</p>
    </div>

    {# Build basket content string: "SKU:quantity;SKU:quantity" #}
    {% set basketContent = [] %}
    {% for item in basket.items %}
        {% set basketContent = basketContent|merge([item.product.code ~ ':' ~ item.quantity]) %}
    {% endfor %}

    {# Track basket addition #}
    {% set basketContext = {
        'basketContent': basketContent|join(';'),
        'basketId': basket.id,
        'quantity': addedQuantity
    } %}

    {{ ibexa_tracking_track_event('basket', product, basketContext) }}

    <a href="{{ path('cart_view') }}">View Cart</a>
{% endblock %}
```

Simplified example with Twig filter:

``` html+twig
{# If you have a custom Twig filter to format basket content #}
{% set basketContext = {
    'basketContent': basket|format_basket_content,  {# Returns "SKU-1:2;SKU-2:1;SKU-3:5" #}
    'basketId': basket.id,
    'quantity': addedQuantity
} %}

{{ ibexa_tracking_track_event('basket', product, basketContext) }}
```

### Custom Templates

You can override the default tracking templates by providing a custom template path:

``` bash
{{ ibexa_tracking_track_event(
    'visit',
    product,
    {},
    '@MyBundle/tracking/custom_visit.html.twig'
) }}
```
