---
description: Integrate the tracking script to collect user interactions.
edition: experience
---

# Tracking script

`ibexa_tracking_script` function allows to embed main tracking script into the website.
It loads the initial script into `window.raptor`, enabling event tracking, for example, page visits, product views, or buys, from the frontend.
It can be overridden in multiple ways to support custom implementations and to render code snippet through [[= product_name_base =]] Design Engine.

Tracking can be conditionally initialized depending on cookie consent logic.
By default, the function returns the script for client-side use, while it can return nothing when used server-side.

## Embedd tracking script

To enable tracking, tracking script must be embedded into the website’s layout.
To embedd tracking script, add the twig function `ibexa_tracking_script()` into the <head> section of your base layout template: `layout.html.twig`.

This function accepts following parameters:

|Parameter     |Type   |Default value                |Remarks                                   |
|--------------|-------|-----------------------------|------------------------------------------|
|`customerId`  |string |From SiteAccess configuration|Can be overridden for custom customer IDs.|
|`hasConsented`|boolean|false                        |Controls loading of tracking based on user consent at render time.|

Example setup:

``` bash
{{ ibexa_tracking_script(customerId: '123', hasConsented: true) }}
```

Without setting custom `customerId` parameter, the function renders the tracking script using the configured `customerID` from the [connector configuration](raptor_connector.md#configuration).
It can be overridden by providing a custom value if needed.

If `hasConsented` is set to `true` in the template, the tracking script is initialized automatically.
This value should be set if user consent for tracking cookies is already known at render time.
If `hasConsented` parameter is set to `false`, tracking should be enabled by dispatching the `enableTracking` CustomEvent after consent is granted, for example through a custom cookie script in layout.

The recommended method to integrate the tracking script with custom front-end logic is to dispatch the `enableTracking` JavaScript event after tracking cookie consent is granted:

``` bash
document.dispatchEvent(new CustomEvent('enableTracking'));
```

!!! note

    In debug (development) mode, the provided script outputs diagnostic information to the console.
    This output is not included in production environment.

## Complex integration

For more complex integrations, the [[= product_name_base =]] Design Engine can be used to override parts or entire templates that render the tracking script.

|Template                                       |Example project path                                       |
|-----------------------------------------------|-----------------------------------------------------------|
|`@ibexadesign/ibexa/tracking/script.html.twig` |`templates/themes/standard/ibexa/tracking/script.html.twig`|
|`@ibexadesign/ibexa/tracking/script.js.twig`   |`templates/themes/standard/ibexa/tracking/script.js.twig`  |

It's possible to extend `script.html.twig` by combining the [[= product_name_base =]] Design Engine with standard Symfony template reference in `./templates/themes/standard/ibexa/tracking/script.html.twig`:

``` html+twig
{% extends '@IbexaConnectorRaptor/themes/standard/ibexa/tracking/script.html.twig' %}
{% block ibexa_tracking_script %}
    console.log('My custom tracking script, but relying on loadTracking function.');
{% endblock %}
```

In most cases, the preferred approach is to do the opposite:

``` bash
<script type="text/javascript">
    if (myCustomConsentIsGiven) {
           {{ include('@ibexadesign/ibexa/tracking/script.js.twig', {'customer_id': customer_id}) }}
    }
</script>
```

### Example custom integration

Example custom integration with [TermsFeed](https://www.termsfeed.com/):

``` bash
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
```
