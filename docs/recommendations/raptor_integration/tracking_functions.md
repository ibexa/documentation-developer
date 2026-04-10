---
description: Integrate the tracking script to collect user interactions.
month_change: true
---

# Raptor tracking functions

[Raptor connector](raptor_connector.md) introduces [visit tracking functionality](https://content.raptorservices.com/help-center/introduction-to-tracking-documentation) for collecting user interactions with products and content.
The implementation includes product visit tracking with mapping to tracking parameters, and Twig functions for straightforward integration.

Raptor integration introduces two Twig functions:

- [`ibexa_tracking_script()`](../../templating/twig_function_reference/recommendations_twig_functions.md#ibexa_tracking_script-function) - allows you to embed main tracking script into the website.
- [`ibexa_tracking_track_event()`](../../templating/twig_function_reference/recommendations_twig_functions.md#ibexa_tracking_track_event-function) - is responsible for sending event data to the service, enabling tracking of user interactions and behaviors.

## Embed tracking script

To enable tracking, tracking script must be embedded into the website’s layout.
To embed tracking script, add the twig function `ibexa_tracking_script()` into the <head> section of your base layout template, for example, `@ibexadesign/pagelayout.html.twig`:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/pagelayout.html.twig') =]]
```

## Tracking modes

Tracking user interactions can be implemented on the client-side or the server-side.
Each approach differs in where events are captured and how they are sent to the tracking backend.

The [tracking Twig function](#embed-tracking-script) outputs different content depending on the mode:

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

The default template defines a `ibexa_tracking_script` Twig block that includes the `script.js.twig` template.
When extending the template, this block can be overridden to customize the script’s behavior.

You can override the default templates, either individually or both at the same time.

## Extending default templates

It's possible to extend `script.html.twig` by combining the [[= product_name_base =]] Design Engine with standard Symfony template reference in `templates/themes/standard/ibexa/tracking/script.html.twig`:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/ibexa/tracking/script.html.twig') =]]
```

As an alternative approach, you can override the template by providing a custom template path:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/ibexa/tracking/script.js.twig') =]]
```

### Example custom integration

Example custom integration with [TermsFeed](https://www.termsfeed.com/):

``` html
[[= include_file('code_samples/recommendations/custom_integration.html') =]]
```
