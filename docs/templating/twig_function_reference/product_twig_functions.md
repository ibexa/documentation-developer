---
description: Product Twig functions enable getting products and their attributes in templates.
page_type: reference
---

# Product Twig functions

### `ibexa_get_product`

The `ibexa_get_product()` filter gets the selected product based on either a product object or a content item object that contains a product.

#### Examples

``` html+twig
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

### `ibexa_has_product_availability`

The `ibexa_has_product_availability` Twig function is used to check whether a product has defined availability.

#### Examples

```html+twig
{% if ibexa_has_product_availability(product) %}
    <!-- Product has availability defined -->
{% else %}
    <!-- Product does not have availability defined -->
{% endif %}
```

### `ibexa_get_product_availability`

The `ibexa_get_product_availability` Twig function retrieves the availability for a product.

#### Examples

```html+twig
{% set availability = ibexa_get_product_availability(product) %}
{% if availability %}
    <!-- Product has availability defined -->
    Availability: {{ availability }}
{% else %}
    <!-- Product does not have availability defined -->
    Availability: Out of stock.
{% endif %}

```

### `ibexa_is_product_available`

The `ibexa_is_product_available` Twig function checks whether a product is available for purchase based on its availability status.

#### Examples

```html+twig
{% if ibexa_is_product_available(product) %}
    <!-- Product is available for purchase -->
    Add to cart
{% else %}
    <!-- Product is not available for purchase -->
    Out of stock
{% endif %}

```

### `ibexa_get_product_stock`

The `ibexa_get_product_stock` Twig function retrieves the stock quantity for a product.

#### Examples

```html+twig
{% set stock = ibexa_get_product_stock(product) %}
{% if stock > 0 %}
    <!-- Display the stock quantity -->
    In stock: {{ stock }} items
{% else %}
    <!-- No stock information available -->
    Out of stock
{% endif %}

```

### `ibexa_format_price`

The `ibexa_format_price` filter formats the price value by placing currency code either on the left or on the right of the numerical value.

#### Examples

``` html+twig
{% for product.price in product.attributes %}
    {{ product.price.getMoney()|ibexa_format_price }}
{% endfor %}
```

### `ibexa_is_pim_local`

The `ibexa_is_pim_local` is a helper Twig function that enables changing the behavior of templates depending on the source of product data.

#### Examples

``` html+twig
{% if ibexa_is_pim_local() == true %}
    <div class="conditional-content">
        <button type="button">Modify product data</button>
    </div>
{% endif %}
```

### `ibexa_product_catalog_group_attributes`

The `ibexa_product_catalog_group_attributes` filter groups product attributes based on the [attribute group]([[= user_doc =]]/pim/work_with_product_attributes/#create-attribute-groups) they belong to.

#### Example

``` html+twig
{% for group, attributes in product.attributes | ibexa_product_catalog_group_attributes %}
    <ul>{{ group.name | capitalize }}
        {% for attribute in attributes %}
            {% set attribute_definition = attribute.attributeDefinition %}
            <li>{{ attribute_definition.name }} : {{ attribute | ibexa_format_product_attribute }}</li>
        {% endfor %}
    </ul>
{% endfor %}
```
