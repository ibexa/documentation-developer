---
description: Storefront Twig function enable controlling the rendering of storefront elements.
edition: commerce
---

# Storefront Twig functions

You can use storefront Twig functions to control the rendering of storefront elements.

## `ibexa_storefront_get_logo()`

`ibexa_storefront_get_logo()` returns current shop logo (configured in `ibexa.system.<scope>.storefront.logo`):

``` html+twig
{% block logo %}
<img src="{{ asset(ibexa_storefront_get_logo()) }}" alt="Logo" />
{% endblock %}
```

## `ibexa_storefront_get_name()`

`ibexa_storefront_get_name()` returns current shop name (configured in `ibexa.system.<scope>.storefront.name`):

``` html+twig
{% block copyright %}
    &copy; {{ null|date('Y') }} {{ ibexa_storefront_get_name() }}
{% endblock %}
```

## `ibexa_storefront_get_main_menu_alias()` / `ibexa_storefront_get_main_menu_options()`

`ibexa_storefront_get_main_menu_alias()` returns the main menu alias.

`ibexa_storefront_get_main_menu_options()` returns the main menu's options (configured in `ibexa.system.<scope>.storefront.main_menu` / `ibexa.system.<scope>.storefront.main_menu_options`).

``` html+twig
{% block main_menu %}
    {% set main_menu_alias = ibexa_storefront_get_main_menu_alias() %}
    {% set main_menu_options = ibexa_storefront_get_main_menu_options() %}

    {{ knp_menu_render(main_menu_alias, main_menu_options) }}
{% endblock %}
```

## `ibexa_storefront_create_inline_product_search_form()`

`ibexa_storefront_create_inline_product_search_form()` creates a product search form:

``` html+twig
{% block search %}
    {{ form(ibexa_storefront_create_inline_product_search_form()) }}
{% endblock %}
```

## `ibexa_storefront_get_main_category()`

`ibexa_storefront_get_main_category()` returns the main (first-level) category for a given category.

For example: if a given category is "Desks" and it has the following ancestors: "Furniture" > "Office" > "Desks",
then the main category for "Office" is "Furniture".

``` html+twig
{% set main_category = ibexa_storefront_get_main_category(category) %}

<p>Main category: {{ main_category.name }}</p>
```

## `ibexa_storefront_get_active_currency()`

`ibexa_storefront_get_active_currency()` returns the active currency object (`Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface`).

``` html+twig
{% set currency = ibexa_storefront_get_active_currency() %}

<p>Active currency code: {{ currency.code }}</p>
```

