# Recommendations Twig functions

Recommendations Twig Functions

The following Twig functions are supported while using [Raptor connector](../../../recommendations/raptor_integration/raptor_connector/index.md):

## `ibexa_tracking_script()` function

The `ibexa_tracking_script()` Twig function allows you to embed the main tracking script into the website. It loads the initial script into `window.raptor`. The script then enables event tracking, such as page visits, product views, or buys, from the front end. It can be overridden in multiple ways to support custom implementations and to render code snippet through Ibexa DXP in the [design engine](../../design_engine/design_engine/index.md).

Tracking can be conditionally initialized depending on cookie consent logic. By default, for client-side use, the function returns a script, but it can return nothing when used server-side.

This function accepts the following parameters:

| Parameter      | Type    | Default value                 | Remarks                                                                                                                                                                           |
| -------------- | ------- | ----------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `customerId`   | string  | From SiteAccess configuration | [Raptor account ID](../../../recommendations/raptor_integration/connector_installation_configuration/index.md#customer-id). Can be overridden for custom customer IDs. |
| `hasConsented` | boolean | false                         | Controls loading of tracking based on user consent at render time.                                                                                                                |

Default setup:

```html+twig
{{ ibexa_tracking_script() }}
```

Example setup using parameters:

```html+twig
{{ ibexa_tracking_script(customerId: '123', hasConsented: true) }}
```

If the custom `customerId` parameter is not set, the function uses the `customerID` from the [connector configuration](../../../recommendations/raptor_integration/connector_installation_configuration/index.md#siteaccess-aware-configuration) to render the tracking script. It can be overridden by providing a custom value if needed.

### Handle tracking consent

If the `hasConsented` parameter is set to `true` in the template, the tracking script is initialized automatically. This value should be set if user consent for tracking cookies is already known at render time. If `hasConsented` is set to `false`, tracking should be enabled by dispatching a custom JavaScript event after consent is granted, for example through a custom script in layout. If it's set dynamically, avoid enabling the [HTTP cache](../../../infrastructure_and_maintenance/cache/http_cache/context_aware_cache/index.md) for users without consent.

The recommended method to integrate the tracking script with custom front-end logic is to dispatch the `enableTracking` JavaScript event after tracking cookie consent is granted:

```js
document.dispatchEvent(new CustomEvent('enableTracking'));
```

> **Note: Note**
>
> In [Symfony's debug mode](https://symfony.com/doc/7.4/reference/configuration/kernel.html#kernel-debug), the provided script outputs diagnostic information to the console. This output is not included in production environment.

## `ibexa_tracking_track_event()` function

The `ibexa_tracking_track_event()` function is responsible for sending event data to the service, which enables tracking of user interactions and behaviors.

Tracking is handled through a Twig function that accept following parameters:

```html+twig
ibexa_tracking_track_event(
    eventType,     {# string: 'visit', 'contentvisit', 'buy', 'basket', 'itemclick' #}
    data,          {# mixed: product, content, or null (optional) #}
    context,       {# array: additional context data (optional) #}
    template       {# string: custom template path (optional) #}
)
```

- **eventType** - type: string, defines the type of tracking event to be sent, for example, `visit`, `contentvisit`, `buy`, `basket`, `itemclick`. For more information, see [Tracking events for recommendations](https://content.raptorservices.com/help-center/tracking-events-parameters-reference).
- **data** (optional) - type: mixed, accepts the primary object associated with the event, such as a Product or Content, can be null if not required. For more information, see [tracking event examples](#tracking-events).
- **context** (optional)- type: array, additional event data, such as quantity, basket details, [website ID](#websiteid-parameter), or custom parameters. For more information, see [example usage](#context-parameter-example-usage).
- **template** (optional) - type: string, path to a custom Twig template used to render the tracking event, allows overriding the default tracking output.

### `websiteId` parameter

The `websiteId`, also known as a **Login ID**, (`p7`) parameter for [Raptor tracking](https://content.raptorservices.com/help-center/introduction-to-tracking-documentation) can be optionally provided as a **context** to `ibexa_tracking_track_event()` function.

When storing customer data in an external Customer Relationship Management (CRM) system, set the `websiteId` to an identifier of the customer stored there.

The following example shows how you pass that value, assuming a custom Twig function `get_custom_crm_identifier` integrating with that CRM exists:

```html+twig
{# Section rendered only for logged-in users #}
{{ ibexa_tracking_track_event('visit', product, {
    websiteId: get_custom_crm_identifier(ibexa_user_get_current().login)
}) }}
```

Set the `websiteId` parameter for logged-id users, for which you have data uniquely identifying them. The value of this parameter serves as a persistent, cross-device identifier of the user. Example values are [User ID](https://content.raptorservices.com/help-center/user-tracking-understanding-soft-ids-hard-ids-raptor-identity-matching#:~:text=IDs%3A-,UserId%20%28Website%20ID) or the Cookie ID.

The value of `websiteId` parameter is resolved in the following order:

1. Explicit `websiteId` passed in the `ibexa_tracking_track_event()` context.
2. Custom [`Ibexa\Contracts\ConnectorRaptor\Tracking\ContextProvider\WebsiteIdContextProviderInterface`](../../../../../../ibexa/connector-raptor/src/contracts/Tracking/ContextProvider/WebsiteIdContextProviderInterface.php) implementations (the first one returning a non-null value wins).
3. The built-in provider, which uses the logged-in user's identifier (`ruid`).

If no value is resolved, the event is sent without the `p7` parameter.

To resolve `websiteId` on the project level, implement the interface as follows:

```php
namespace App\Tracking;

use Ibexa\Contracts\ConnectorRaptor\Tracking\ContextProvider\WebsiteIdContextProviderInterface;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;

final readonly class MyCrmWebsiteUserIdProvider implements WebsiteIdContextProviderInterface
{
    public function __construct(
        private ConfigResolverInterface $configResolver,
        private PermissionResolver $permissionResolver,
    ) {
    }

    public function getWebsiteId(): ?string
    {
        $currentUserId = $this->permissionResolver->getCurrentUserReference()->getUserId();
        // Don't resolve for anynomous user
        if ($this->isAnonymousUser($currentUserId)) {
            return null;
        }

        return $this->getWebsiteUserIdForCurrentUser($currentUserId);
    }

    /**
     * @phpstan-return non-empty-string
     */
    private function getWebsiteUserIdForCurrentUser(int $userId): string
    {
        // Implement custom logic resolving user identifier from the CRM
        return 'custom-identifier-for-the-user-retrieved-from-the-CRM';
    }

    private function isAnonymousUser(int $userId): bool
    {
        return (int) $this->configResolver->getParameter('anonymous_user_id') === $userId;
    }
}
```

The provider is registered automatically. Implementing the interface is sufficient, no service configuration is required.

> **Note: Note**
>
> Custom provider takes precedence over the built-in one. A provider must return either `null` or a non-empty string.

If you register multiple providers, control their order by tagging the service with a priority (higher priority is checked first):

```yaml
App\Tracking\MyWebsiteIdProvider:
    tags:
        - { name: ibexa.connector.raptor.tracking.website_id_context_provider, priority: 50 }
```

### Tracking events

The following events are supported and can be triggered from Twig templates:

#### `pageview` event

The `ibexa_tracking_script()` Twig function automatically sends a [`pageview`](https://content.raptorservices.com/help-center/tracking-events-parameters-reference) event to Raptor for every incoming GET request, in both `client` and `server` tracking types.

Use it for basic page metrics and debugging the Live Tracking Stream.

#### Product `visit` event

This event tracks product page visits by users. It's the most common e-commerce tracking event used to capture product views for analytics, recommendation models, and user behavior processing.

Required data:

- **Product object** - defines the product being tracked. It implements [`Ibexa\Contracts\ProductCatalog\Values\ProductInterface`](../../../../../../ibexa/product-catalog/src/contracts/Values/ProductInterface.php) so the system can read its information (for example, code, price, category).

Example:

```html+twig
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

#### `contentvisit` event

This event tracks content page visits by users. It implements [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php) and can be used to check content views for analytics, personalization, and user behavior tracking.

- **Content object** - defines the content being tracked.

Example:

```html+twig
{# templates/bundles/IbexaCoreBundle/default/content/full.html.twig #}
{% extends '@!IbexaCore/default/content/full.html.twig' %}

{% block content %}
    {{ parent() }}
    {{ ibexa_tracking_track_event('contentvisit', content) }}
{% endblock %}
```

#### Product `buy` event

This event tracks when a product is bought.

- **Product object** defines the product being purchased.
- **Context array with purchase conditions** - provides optional data about the product purchase context, like quantity, price, or currency.

```html+twig
{% set buyContext = {
    'subtotal': '10.00',
    'currency': 'EUR',
    'quantity': 1
} %}
{{ ibexa_tracking_track_event('buy', product, buyContext) }}
```

#### Product `basket` event

This event tracks when a product is added to the [cart](../../../commerce/cart/cart/index.md).

It captures user interactions that indicate interest, which can be used for conversion tracking and to improve product recommendations.

Required data:

- **Product object** - defines the product being added to the basket.
- **Context array with cart information** - provides optional data about the cart, like product quantity or cart identifier, to provide context for the event.

Example:

```html+twig
{# templates/cart/add_confirmation.html.twig #}
{% extends 'base.html.twig' %}

{% block content %}
    <div class="cart-notification">
        <p>Product "{{ product.name }}" has been added to your cart!</p>
        <p>Quantity: {{ addedQuantity }}</p>
    </div>

    {# Build basket content string: "product-code:quantity;product-code:quantity" #}
    {% set basketContent = [] %}
    {% for entry in cart.entries %}
        {% set basketContent = basketContent|merge([entry.product.code ~ ':' ~ entry.quantity]) %}
    {% endfor %}
    {# Track basket addition #}
    {% set basketContext = {
        'basketContent': basketContent|join(';'),
        'basketId': cart.id,
        'quantity': addedQuantity
    } %}

    {{ ibexa_tracking_track_event('basket', product, basketContext) }}

    <a href="{{ path('cart_view') }}">View Cart</a>
{% endblock %}
```

#### `itemclicked` event

This event tracks when a user clicks a Raptor recommendation, including adding products to the cart from the recommendation module.

Required data:

- **Product code** - code of the product the visitor interacted with.
- **Context** - provides optional data, like `moduleName` or `redirectUrl`, to provide context for the event.

Example:

```html+twig
{{ ibexa_tracking_track_event('itemclick', product.code, {
    'moduleName': 'homepage-recommendations',
    'redirectUrl': path('ibexa.product.view', {'productCode': product.code})
}) }}
```

### `context` parameter - example usage

You can use the `context` parameter to pass additional data.

During tracking, for products assigned to multiple categories, the system uses the first category. In this case, `context` allows to override the product category by passing a category identifier:

```html+twig
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

For other usage examples, see the [`buy`](#product-buy-event) and [`basket`](#product-basket-event) events.

### Custom templates

You can create a custom template for tracking in the `/templates/tracking/` directory. See the following example of `custom_visit.html.twig`:

```html+twig
{# templates/tracking/custom_visit.html.twig #}

{#
# Custom visit tracking template
#
# Available variables, passed to the template by `ibexa_tracking_track_event`:
# - parameters: array of Raptor tracking parameters (p1, p2, p3, etc.)
# - debug: boolean flag to enable debug console messages
#}

<script type="text/javascript">
    {% autoescape 'js' %}
        (function () {
            // Custom logic before tracking
            {# For example, always override the website ID by editing the received parameters: #}
            {% set parameters = parameters|merge({'p7': 'custom-website-id'}) %}
            {% if debug %}
            console.log('Custom visit tracking template');
            console.log('Tracking parameters:', {{ parameters|json_encode|raw }});
            {% endif %}  

            // Send the tracking event (REQUIRED for tracking to work)
            const event = 'trackEvent'; // Don't change this - Raptor API method name
            const params = {{ parameters|json_encode|raw }};
            window.raptor.push(event, params);

            // Custom logic after tracking
            {% if debug %}
            console.log('Visit event tracked successfully');
            {% endif %}
        })();
    {% endautoescape %}
</script>
```

You can override the default tracking templates by providing a custom template path:

```html+twig
{{ ibexa_tracking_track_event(
      'visit',
      product,
      {},
      '@App/tracking/custom_visit.html.twig'
) }}
```
