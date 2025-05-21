---
description: Twig Components allow you to inject custom widgets into selected templates
page_type: reference
---

# Twig Component functions

## `ibexa_twig_component_group`

The `ibexa_twig_component_group` function renders the specified [Twig Component](components.md) group.
You can pass optional parameters as the second argument. They are passed to the `\Ibexa\Contracts\TwigComponents\Renderer\RendererInterface` service and then to the rendered component.

### Examples

``` html+twig
{{ ibexa_twig_component_group('storefront-before-maincart', {
    'cart' : cart|default(null)
}) }}
```

## `ibexa_twig_component`

The `ibexa_twig_component` function renders a single Twig Component from the specified group.
You can pass optional parameters as the third argument. They are passed to the `\Ibexa\Contracts\TwigComponents\Renderer\RendererInterface` service and then to the rendered component.

### Examples

``` html+twig
{{ ibexa_twig_component('storefront-before-maincart', 'my-component', {
    'cart' : cart|default(null)
}) }}
```
