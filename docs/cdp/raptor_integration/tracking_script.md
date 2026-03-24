---
description: Integrate the tracking script to collect user interactions.
edition: experience
---

# Client‑side tracking script

To enable client‑side tracking, a tracking script must be embedded into the website’s layout.
The script exposes a global object on window.R, which can be used to push tracking events (for example, page visits, product views, buys) from the frontend.
Tracking can be conditionally initialized depending on cookie consent logic.

## Embedd tracking script

To embedd tracking script, first add the Twig function `ibexa_tracking_script()` into the <head> section of your base layout template: `layout.html.twig`.

This function accepts following parameters:

|Parameter     |Type   |Default value                |Remarks                                   |
|--------------|-------|-----------------------------|------------------------------------------|
|`customerId`  |string |From SiteAccess configuration|Can be overridden for custom customer IDs.|
|`hasConsented`|boolean|false                        |Controls loading of tracking based on user consent at render time.|

Without setting parameters, the function renders the tracking script using the configured `customerID` from the system configuration.

Example configuration:

```bash
{{ ibexa_tracking_script({ customerId: 'NN‑123', hasConsented: true }) }}
```

The recommended method to integrate the tracking script with custom front-end logic is to dispatch the `enableTracking` JavaScript event after tracking cookie consent is granted:

``` bash
document.dispatchEvent(new CustomEvent('enableTracking'));
```

If `hasConsented` is set to `true` in the template, the tracking script is initialized automatically.

!!! note

    In debug (development) mode, the provided script outputs diagnostic information to the console.
    This output is not included in production environment.
