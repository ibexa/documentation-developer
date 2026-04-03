---
description: Tracking with PHP API.
month_change: true
---

# Tracking with PHP API

You can interact directly with the service using the PHP API for advanced tracking usage.

## Advanced usage – direct interaction with the service

### `EventMapper` method

The recommended method, providing full control over event tracking, is `EventMapper` method.
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

### Example - event subscriber

If you need to track events automatically based on application events, you can use Event Subscriber.
It reacts to specific events in the application and triggers tracking logic without the need to add it manually in templates.

``` php
[[= include_file('code_samples/recommendations/EventSubscriber.php') =]]
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
[[= include_file('code_samples/recommendations/events/product_visit_event.html.twig') =]]
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
[[= include_file('code_samples/recommendations/events/basket_event.html.twig') =]]
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

## Complex integration

For more complex integrations, the [[= product_name_base =]] Design Engine can be used to override parts or entire templates that render the tracking script.

|Template|Description|Example project path|
|--------|-----------|--------------------|
|`@ibexadesign/ibexa/tracking/script.html.twig`|Responsible for creating the `window.raptor` object and handling consent. Loads tracking only if consent is given and listens for the `enableTracking` event.|`templates/themes/standard/ibexa/tracking/script.html.twig`|
|`@ibexadesign/ibexa/tracking/script.js.twig`|Handles the loading of the tracking JavaScript.|`templates/themes/standard/ibexa/tracking/script.js.twig`  |

Available variables are:

- **customer_id** - type: string, Raptor account ID used for tracking
- **script_url** - type: string, URL of the tracking script, by default `//deliver.raptorstatic.com/script/raptor-3.0.min.js`, configurable through `ibexa.connector.raptor.tracking_script.url` Symfony Dependency Injection container parameter (not SiteAccess-aware)
- **has_consented** - type: boolean, indicates whether the user has given consent, default value: `false` (unless explicitly passed as function argument)
- **debug** - type: boolean, `kernel.debug` Symfony dependency injection container parameter, typically `true` in development environments and `false` in production

The default template defines a Twig block that includes `script.js.twig`.
When extending the template, this block can be overridden to customize the script’s behavior.

You can override the default templates, either individually or both at the same time.

## Extension

It's possible to extend `script.html.twig` by combining the [[= product_name_base =]] Design Engine with standard Symfony template reference in `templates/themes/standard/ibexa/tracking/script.html.twig`:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/ibexa/tracking/script.html.twig') =]]
```

In most cases, the preferred approach is to do the opposite:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/ibexa/tracking/script.js.twig') =]]
```

### Example custom integration

Example custom integration with [TermsFeed](https://www.termsfeed.com/):

``` html
[[= include_file('code_samples/recommendations/custom_integration.html') =]]
```
