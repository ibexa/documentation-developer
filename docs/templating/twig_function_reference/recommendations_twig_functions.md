---
description: Recommendations Twig Functions
month_change: true
---

# Recommendations Twig functions

The following Twig functions are supported while using [Raptor connector](raptor_connector.md):

## `ibexa_tracking_script()` function

`ibexa_tracking_script()` Twig function allows you to embed main tracking script into the website.
It loads the initial script into `window.raptor`, enabling events tracking, for example, page visits, product views, or buys, from the front-end.
It can be overridden in multiple ways to support custom implementations and to render code snippet through `[[= product_name_base =]]` in [Design Engine](../../templating/design_engine/design_engine.md).

Tracking can be conditionally initialized depending on cookie consent logic.
By default, the function returns the script for client-side use, while it can return nothing when used server-side.

This function accepts the following parameters:

|Parameter     |Type   |Default value                |Remarks                                   |
|--------------|-------|-----------------------------|------------------------------------------|
|`customerId`  |string |From SiteAccess configuration|[Raptor account ID](connector_installation_configuration.md#customer-id). Can be overridden for custom customer IDs.|
|`hasConsented`|boolean|false                        |Controls loading of tracking based on user consent at render time.|

Default setup:

``` html+twig
{{ ibexa_tracking_script() }}
```
Example setup using parameters:

``` html+twig
{{ ibexa_tracking_script(customerId: '123', hasConsented: true) }}
```

Without setting custom `customerId` parameter, the function renders the tracking script using the configured `customerID` from the [connector configuration](connector_installation_configuration.md#siteaccess-aware-configuration).
It can be overridden by providing a custom value if needed.

If `hasConsented` is set to `true` in the template, the tracking script is initialized automatically.
This value should be set if user consent for tracking cookies is already known at render time.
If `hasConsented` parameter is set to `false`, tracking should be enabled by dispatching a custom JavaScript event after consent is granted, for example through a custom script in layout.
When set dynamically, avoid enabling the [HTTP cache](context_aware_cache.md) for users without consent.

The recommended method to integrate the tracking script with custom front-end logic is to dispatch the `enableTracking` JavaScript event after tracking cookie consent is granted:

``` js
document.dispatchEvent(new CustomEvent('enableTracking'));
```

!!! note

    In [Symfony's debug mode]([[= symfony_doc =]]/reference/configuration/kernel.html#kernel-debug), the provided script outputs diagnostic information to the console.
    This output is not included in production environment.

## `ibexa_tracking_track_event()` function

The `ibexa_tracking_track_event()` function is responsible for sending event data to the service, enabling tracking of user interactions and behaviors.

Tracking is handled through twig function that accept following parameters:

``` html+twig
ibexa_tracking_track_event(
    eventType,     {# string: 'visit', 'contentvisit', 'buy', 'basket', 'itemclick' #}
    data,          {# mixed: product, content, or null (optional) #}
    context,       {# array: additional context data (optional) #}
    template       {# string: custom template path (optional) #}
)
```

- **eventType** - type: string, defines the type of tracking event to be sent, for example, `visit`, `contentvisit`, `buy`, `basket`, `itemclick`. For more information, see [Tracking events for recommendations](https://content.raptorservices.com/help-center/tracking-events-for-recommendation).
- **data** (optional) - type: mixed, accepts the primary object associated with the event, such as a Product or Content, can be null if not required. For more information, check [tracking event examples](#tracking-events).
- **context** (optional)- type: array, additional event data, such as quantity, basket details, or custom parameters. For more information, see [example usage](#context-parameter-example-usage).
- **template** (optional) - type: string, path to a custom Twig template used to render the tracking event, allows overriding the default tracking output

#### Tracking events

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

Example:

``` html+twig
[[= include_file('code_samples/recommendations/events/content_visit_event.html.twig') =]]
```

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
[[= include_file('code_samples/recommendations/events/basket_event_simplified.html.twig') =]]
```

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

    {# Track with category identifier - CategoryID automatic loading and formatting #}
        {{ ibexa_tracking_track_event('visit', product, {
        'categoryIdentifier': 'electronics'
    }) }}
{% endblock %}
```

For another example of `context` parameter usage, see [Basket event](#basket-event).

### Custom Templates

You can create a custom template for tracking in the `/templates/tracking/` directory.
Check the following `custom_visit.html.twig` example:

``` html+twig
[[= include_file('code_samples/recommendations/templates/tracking/custom_visit.html.twig') =]]
```

You can override the default tracking templates by providing a custom template path:

``` html+twig
{{ ibexa_tracking_track_event(
      'visit',
      product,
      {},
      '@App/tracking/custom_visit.html.twig'
) }}
```
