# Raptor tracking functions

Integrate the tracking script to collect user interactions.

[Raptor connector](../raptor_connector/index.md) introduces [visit tracking functionality](https://content.raptorservices.com/help-center/introduction-to-tracking-documentation) for collecting user interactions with products and content. The implementation includes product visit tracking with mapping to tracking parameters, and Twig functions for straightforward integration.

Raptor integration introduces two Twig functions:

- [`ibexa_tracking_script()`](../../../templating/twig_function_reference/recommendations_twig_functions/index.md#ibexa_tracking_script-function) - allows you to embed main tracking script into the website.
- [`ibexa_tracking_track_event()`](../../../templating/twig_function_reference/recommendations_twig_functions/index.md#ibexa_tracking_track_event-function) - is responsible for sending event data to the service, enabling tracking of user interactions and behaviors.

## Embed tracking script

You must embed the tracking script into the website’s layout to enable tracking. To do it, add the `ibexa_tracking_script()` Twig function into the section of your base layout template, for example, `@ibexadesign/pagelayout.html.twig`:

```html+twig
{# templates/pagelayout.html.twig #}
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

## Tracking modes

Tracking user interactions can be implemented on the client-side or the server-side. Each approach differs in where events are captured and how they are sent to the tracking backend.

The [tracking Twig function](#embed-tracking-script) outputs different content depending on the mode:

```yaml
# Server-side tracking
connector_raptor:
    tracking_type: 'server'  # Returns nothing (prod) or HTML comments (dev)

# Client-side tracking
connector_raptor:
    tracking_type: 'client'  # Returns <script> tags

# Hybrid tracking
connector_raptor:
    tracking_type: 'hybrid'  # # Returns <script> tags (loads a first-party proxy shim, not the Raptor SaaS script)
```

- **server** - doesn't return anything in the `prod` environment, while returns HTML comments in the `dev` environment or any environment where `kernel.debug` Symfony container parameter is set to `true`. Tracking is performed server-side.
- **client** - returns `script` tags to load the tracking script in the browser.
- **hybrid** - returns script tags like `client`, but they load a first-party shim (`raptor-proxy.js`) that forwards events to a same-origin proxy endpoint instead of the Raptor SaaS script. The server then delivers them to Raptor, preventing ad blockers from blocking tracking.

You can switch tracking mode anytime by changing the `tracking_type` parameter.

For more information on Tracking modes, see documentation:

- [Client-side tracking](https://content.raptorservices.com/help-center/client-side-tracking)
- [Server-side tracking](https://content.raptorservices.com/help-center/server-side-tracking)
- [Client-side vs. Server-side tracking](https://content.raptorservices.com/help-center/client-side-vs.-server-side-tracking)
- [Hybrid tracking](../hybrid_tracking/index.md)

## Complex integration

For more complex integrations, the Ibexa Design Engine can be used to override parts or entire templates that render the tracking script.

| Template                                       | Description                                                                                                                                                   | Example project path                                        |
| ---------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------- |
| `@ibexadesign/ibexa/tracking/script.html.twig` | Responsible for creating the `window.raptor` object and handling consent. Loads tracking only if consent is given and listens for the `enableTracking` event. | `templates/themes/standard/ibexa/tracking/script.html.twig` |
| `@ibexadesign/ibexa/tracking/script.js.twig`   | Handles the loading of the tracking JavaScript.                                                                                                               | `templates/themes/standard/ibexa/tracking/script.js.twig`   |

Available variables are:

- **customer_id** - type: string, Raptor account ID used for tracking
- **script_url** - type: string, URL of the tracking script, by default `//deliver.raptorstatic.com/script/raptor-3.0.min.js`, configurable through `ibexa.connector.raptor.tracking_script.url` Symfony Dependency Injection container parameter (not SiteAccess-aware)
- **has_consented** - type: boolean, indicates whether the user has given consent, default value: `false` (unless explicitly passed as function argument)
- **debug** - type: boolean, `kernel.debug` Symfony dependency injection container parameter, typically `true` in development environments and `false` in production

The default template defines a `ibexa_tracking_script` Twig block that includes the `script.js.twig` template. When extending the template, this block can be overridden to customize the script’s behavior.

You can override the default templates, either individually or both at the same time.

## Extending default templates

It's possible to extend `script.html.twig` by combining the Ibexa Design Engine with standard Symfony template reference in `templates/themes/standard/ibexa/tracking/script.html.twig`:

```html+twig
{% extends '@IbexaConnectorRaptor/themes/standard/ibexa/tracking/script.html.twig' %}
{% block ibexa_tracking_script %}
    console.log('My custom tracking script, but relying on loadTracking function.');
{% endblock %}
```

As an alternative approach, you can override the template by providing a custom template path:

```html+twig
<script type="text/javascript">
    if (myCustomConsentIsGiven) {
        {{ include('@ibexadesign/ibexa/tracking/script.js.twig', {'customer_id': customer_id}) }}
    }
</script>
```

### Example custom integration

Example custom integration with [TermsFeed](https://www.termsfeed.com/):

````html
``` html
<!-- Cookie Consent by TermsFeed https://www.TermsFeed.com -->
<script type="text/javascript" src="https://www.termsfeed.com/public/cookie-consent/4.2.0/cookie-consent.js" charset="UTF-8"></script>
<script type="text/javascript" charset="UTF-8">
    document.addEventListener('DOMContentLoaded', function () {
        cookieconsent.run({
            "notice_banner_type": "simple",
            "consent_type": "implied",
            "palette": "dark",
            "language": "en",
            "page_load_consent_levels": ["strictly-necessary"],
            "notice_banner_reject_button_hide": false,
            "preferences_center_close_button_hide": false,
            "page_refresh_confirmation_buttons": false,
            "website_name": "Ibexa Storefront",
            "callbacks": {
                "scripts_specific_loaded": (level) => {
                    switch(level) {
                        case 'tracking':
                            document.dispatchEvent(new CustomEvent('enableTracking'));
                            break;
                    }
                }
            },
            "callbacks_force": true
        });
    });
</script>
<noscript>Free cookie consent management tool by <a href="https://www.termsfeed.com/">TermsFeed</a></noscript>
<!-- End Cookie Consent by TermsFeed https://www.TermsFeed.com -->
````

```
```
