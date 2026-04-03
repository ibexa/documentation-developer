---
description: Integrate the tracking script to collect user interactions.
month_change: true
---

# Raptor tracking functions

Raptor [tracking functions](https://content.raptorservices.com/help-center/introduction-to-tracking-documentation) introduce visit tracking functionality for collecting user interactions with products and content.
The implementation includes product visit tracking with mapping to tracking parameters, as well as Twig functions for straightforward integration.

## `ibexa_tracking_script()` Twig function

[`ibexa_tracking_script()`](../../templating/twig_function_reference/recommendations_twig_functions.md) Twig function allows you to embed main tracking script into the website.
It loads the initial script into `window.raptor`, enabling events tracking, for example, page visits, product views, or buys, from the front-end.
It can be overridden in multiple ways to support custom implementations and to render code snippet through `[[= product_name_base =]]` in [Design Engine](../../templating/design_engine/design_engine.md).

Tracking can be conditionally initialized depending on cookie consent logic.
By default, the function returns the script for client-side use, while it can return nothing when used server-side.

### Embed tracking script

To enable tracking, tracking script must be embedded into the website’s layout.
To embed tracking script, add the twig function `ibexa_tracking_script()` into the <head> section of your base layout template, for example, `pagelayout.html.twig`.

This function accepts the following parameters:

|Parameter     |Type   |Default value                |Remarks                                   |
|--------------|-------|-----------------------------|------------------------------------------|
|`customerId`  |string |From SiteAccess configuration|[Raptor account ID](.../.../raptor_integration/connector_configuration/#customer-id). Can be overridden for custom customer IDs.|
|`hasConsented`|boolean|false                        |Controls loading of tracking based on user consent at render time.|

Default setup:

``` html+twig
{{ ibexa_tracking_script() }}
```
Example setup using parameters:

``` html+twig
{{ ibexa_tracking_script(customerId: '123', hasConsented: true) }}
```

Without setting custom `customerId` parameter, the function renders the tracking script using the configured `customerID` from the [connector configuration](raptor_connector.md#configuration).
It can be overridden by providing a custom value if needed.

If `hasConsented` is set to `true` in the template, the tracking script is initialized automatically.
This value should be set if user consent for tracking cookies is already known at render time.
If `hasConsented` parameter is set to `false`, tracking should be enabled by dispatching a custom JavaScript event after consent is granted, for example through a custom script in layout.

The recommended method to integrate the tracking script with custom front-end logic is to dispatch the `enableTracking` JavaScript event after tracking cookie consent is granted:

``` js
document.dispatchEvent(new CustomEvent('enableTracking'));
```

!!! note

    In [Symfony's debug mode]([[= symfony_doc =]]/reference/configuration/kernel.html#kernel-debug), the provided script outputs diagnostic information to the console.
    This output is not included in production environment.

### Complex integration

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

### Extension

It's possible to extend `script.html.twig` by combining the [[= product_name_base =]] Design Engine with standard Symfony template reference in `templates/themes/standard/ibexa/tracking/script.html.twig`:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/ibexa/tracking/script.html.twig') =]]
```

In most cases, the preferred approach is to do the opposite:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/ibexa/tracking/script.js.twig') =]]
```

#### Example custom integration

Example custom integration with [TermsFeed](https://www.termsfeed.com/):

``` html
[[= include_file('code_samples/recommendations/custom_integration.html') =]]
```

## `ibexa_tracking_script()` Twig function
