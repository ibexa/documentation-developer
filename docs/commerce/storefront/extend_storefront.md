---
description: Extend Storefront with new menus.
edition: commerce
---

# Extend Storefront

## Built-in menus

With the `ibexa\storefront` package come the following built-in menus:

| Item   | Value     | Description |
|------------|----------|---------|
| [Breadcrumbs](#breadcrumbs-menu)| - | Renders breadcrumbs for Content Tree Root, Taxonomy Entry, Product, User settings and User settings group | 
| [Taxonomy](#taxonomy-menu)| - | Renders a menu to change the active currency |               
| Currency| `currency_menu` | Renders a menu to change the active currency |               
| Language| `language_menu` | Renders a menu to change the active language |
| Region  | `region_menu`  | Renders a menu to change the active region |

Usage example:

```html_twig
{% set currrency_menu = knp_menu_get('ibexa_storefront.menu.currency') %}

{{ knp_menu_render(currrency_menu) }}
```

### Breadcrumbs menu

To modify the items in the menu, you need to use an event subscriber.
This subscriber replaces the URI under the `Home` link.

Create an event subscriber in `src/EventSubscriber/BreadcrumbsMenuSubscriber.php`:

``` php
[[= include_file('code_samples/front/shop/storefront/src/EventSubscriber/BreadcrumbsMenuSubscriber.php') =]]
```

Next, create the `templates/themes/storefront/storefront/knp_menu/breadcrumbs.html.twig` template:

```html+twig
[[= include_file('code_samples/front/shop/storefront/templates/themes/storefront/storefront/knp_menu/breadcrumbs.html.twig') =]]
```

Next, extend the `templates/themes/storefront/storefront/product.html.twig` template to include the breadcrumbs:

```html+twig hl_lines="6-12"
[[= include_file('code_samples/front/shop/storefront/templates/themes/storefront/storefront/product.html.twig') =]]
```

### Taxonomy menu

You can build a taxonomy menu for, for example, product categories or tags.

See the usage example:

```html+twig
{% set categories_menu = knp_menu_get(
    'ibexa_storefront.menu.taxonomy', 
    [], 
    {
        parent: category,
        depth: 3
    }
) %}

{{ knp_menu_render(categories_menu) }}
```

It takes the following parameters:

| Name   | Type     | Default                                 |
|------------|----------|-----------------------------------------------|
| `parent`| `\Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry` | The root entry of the specified taxonomy.                          |
| `depth` | `int` | Default: 1   |
| `taxonomy_name`  | `string`  | product_categories |

## Create menu items

`\Ibexa\Contracts\Storefront\Menu\ItemFactoryInterface` provides convenient methods to build menu item based on repository objects, including:

- Content
- Content ID
- Location
- Location ID
- Taxonomy Entry
- Product

