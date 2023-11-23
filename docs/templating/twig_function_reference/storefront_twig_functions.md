---
description: Storefront Twig function enable controlling the rendering of storefront elements.
edition: commerce
page_type: reference
---

# Storefront Twig functions

You can use storefront Twig functions to control the rendering of storefront elements.

### `ibexa_storefront_get_logo()`

`ibexa_storefront_get_logo()` returns current shop logo (configured in `ibexa.system.<scope>.storefront.logo`):

``` html+twig
{% block logo %}
<img src="{{ asset(ibexa_storefront_get_logo()) }}" alt="Logo" />
{% endblock %}
```

### `ibexa_storefront_get_name()`

`ibexa_storefront_get_name()` returns current shop name (configured in `ibexa.system.<scope>.storefront.name`):

``` html+twig
{% block copyright %}
    &copy; {{ null|date('Y') }} {{ ibexa_storefront_get_name() }}
{% endblock %}
```

### `ibexa_storefront_get_main_menu_alias()` / `ibexa_storefront_get_main_menu_options()`

`ibexa_storefront_get_main_menu_alias()` returns the main menu alias.

`ibexa_storefront_get_main_menu_options()` returns the main menu's options (configured in `ibexa.system.<scope>.storefront.main_menu` / `ibexa.system.<scope>.storefront.main_menu_options`).

``` html+twig
{% block main_menu %}
    {% set main_menu_alias = ibexa_storefront_get_main_menu_alias() %}
    {% set main_menu_options = ibexa_storefront_get_main_menu_options() %}

    {{ knp_menu_render(main_menu_alias, main_menu_options) }}
{% endblock %}
```

### `ibexa_storefront_create_inline_product_search_form()`

`ibexa_storefront_create_inline_product_search_form()` creates a product search form:

``` html+twig
{% block search %}
    {{ form(ibexa_storefront_create_inline_product_search_form()) }}
{% endblock %}
```

### `ibexa_storefront_get_main_category()`

`ibexa_storefront_get_main_category()` returns the main (first-level) category for a given category.

For example: if a given category is "Desks" and it has the following ancestors: "Furniture" > "Office" > "Desks",
then the main category for "Office" is "Furniture".

``` html+twig
{% set main_category = ibexa_storefront_get_main_category(category) %}

<p>Main category: {{ main_category.name }}</p>
```

### `ibexa_storefront_get_active_currency()`

`ibexa_storefront_get_active_currency()` returns the active currency object (`Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface`).

``` html+twig
{% set currency = ibexa_storefront_get_active_currency() %}

<p>Active currency code: {{ currency.code }}</p>
```

### `ibexa_storefront_get_language_name_by_code()`

`ibexa_storefront_get_language_name_by_code()` displays language name based on its code or locale.

``` html+twig
{% set languageName = ibexa_storefront_get_language_name_by_code(languageCode) %}

<p>Language name: {{ languageName }}</p>
```

### `ibexa_storefront_get_product_render_action()`

`ibexa_storefront_get_product_render_action()` returns a rendering action to be used, as defined in [settings](configure_storefront.md).
You can use this, for example, to [parametrize the display of products by using a custom controller](extend_storefront.md#generate-custom-product-preview-path).

``` html+twig
{% if ibexa_is_pim_local() %}
    {{ ibexa_render(product, { method: 'esi', viewType: 'card' }) }}
{% else %}
    {{ render(
        controller(ibexa_storefront_get_product_render_action(), {
            product: product
        })
    ) }}
{% endif %}
```