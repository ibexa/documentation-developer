---
description: Site context Twig function determines if given location is site context-aware.
edition: experience
page_type: reference
---

# Site context Twig functions

You can use site context Twig functions to determine if given location is site context-aware.

### `ibexa_site_context_aware()`

`ibexa_site_context_aware()` checks whether a given location is site context-aware.

#### Examples

``` html+twig
{% if location is ibexa_site_context_aware %}
    <p>I am aware of the site context!</p>
{% endif %}
```