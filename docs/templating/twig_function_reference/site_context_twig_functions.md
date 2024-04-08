---
description: Site context Twig function determines if given location is site context-aware.
edition: experience
page_type: reference
---

# Site context Twig functions

To determine if given location is site context-aware, you can use site context [Twig test](https://twig.symfony.com/doc/3.x/tests/index.html).

### `ibexa_site_context_aware()`

`ibexa_site_context_aware()` checks whether a given location is site context-aware.

#### Examples

``` html+twig
{% if location is ibexa_site_context_aware %}
    <p>I am aware of the site context!</p>
{% endif %}
```