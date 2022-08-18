---
description: Product Twig functions enable getting products and their attributes in templates.
---

# Product Twig functions

### `ibexa_get_product`

The `ibexa_get_product()` filter gets the selected product
based on either a product object or a Content item object that contains a product.

#### Examples

``` hmml+twig
{{ (product|ibexa_get_product).code }}
{{ (content|ibexa_get_product).code }}
```

### `ibexa_format_product_attribute`

The `ibexa_format_product_attribute` filter formats the attribute value to a readable, translated form.

#### Examples

``` html+twig
{% for attribute in product.attributes %}
    {{ attribute|ibexa_format_product_attribute }}
{% endfor %}
```

### `ibexa_product`

`ibexa_product` enables you to check whether the provided object is a product.

#### Examples

``` html+twig
{$ if content is ibexa_product %}
```
