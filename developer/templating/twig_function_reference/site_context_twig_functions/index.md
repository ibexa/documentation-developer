# Site context Twig functions

Site context Twig function determines if given location is site context-aware.

Editions: Experience

To determine if given location is site context-aware, you can use site context [Twig test](https://twig.symfony.com/doc/3.x/tests/index.html).

## `ibexa_site_context_aware()`

`ibexa_site_context_aware()` checks whether a given location is site context-aware, meaning it's not excluded from Site context by using the `ibexa.system.<scope>.site_context.excluded_paths` configuration.

### Examples

```html+twig
{% if location is ibexa_site_context_aware %}
    <p>I am aware of the site context!</p>
{% endif %}
```
