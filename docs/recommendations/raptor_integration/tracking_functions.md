---
description: Integrate the tracking script to collect user interactions.
month_change: true
---

# Raptor tracking functions

Raptor [tracking functions](https://content.raptorservices.com/help-center/introduction-to-tracking-documentation) introduce visit tracking functionality for collecting user interactions with products and content.
The implementation includes product visit tracking with mapping to tracking parameters, as well as Twig functions for straightforward integration.

Raptor integration introduces two Twig functions:

- [`ibexa_tracking_script()`](../../templating/twig_function_reference/recommendations_twig_functions.md#ibexa_tracking_script-function) - allows you to embed main tracking script into the website.
- [`ibexa_tracking_track_event()`](../../templating/twig_function_reference/recommendations_twig_functions.md#ibexa_tracking_track_event-function) - is responsible for sending event data to the service, enabling tracking of user interactions and behaviors.

## Embed tracking script

To enable tracking, tracking script must be embedded into the website’s layout.
To embed tracking script, add the twig function `ibexa_tracking_script()` into the <head> section of your base layout template, for example, `pagelayout.html.twig`:

``` html+twig
[[= include_file('code_samples/recommendations/templates/themes/standard/pagelayout.html.twig') =]]
```

## Tracking modes

Tracking user interactions can be implemented on the client-side or the server-side.
Each approach differs in where events are captured and how they are sent to the tracking backend.

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
