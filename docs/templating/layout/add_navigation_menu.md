---
description: Enrich you site front with a menu displaying selected Content items.
---

# Add navigation menu

To add a navigation menu to your website, prepare a general layout template in a `templates/themes/<theme_name>/pagelayout.html.twig` file.

This template can contain things such as header, menu, footer, as well as [assets](assets.md) for the whole site,
and all other templates [extend](templates.md#connecting-templates) it.

To select items that should be rendered in the menu, you can use one of the following ways:

- create a [query](#render-menu-using-a-query)
- create a [MenuBuilder](#create-a-menubuilder)

## Render menu using a query

To create a menu that contains a specific set of Content items, for example all content under the root Location, use a [Query Type](content_queries.md).

First, in `src/QueryType`, create a custom `MenuQueryType.php` file that queries for all items that you want in the menu:

``` php hl_lines="15 16 28"
[[= include_file('code_samples/front/layouts/menu/src/QueryType/MenuQueryType.php') =]]
```

In this case, it queries for all visible children of Location `2`, the root Location, (lines 15-16)
and renders them in order according to their Location priority.

The Query Type has the name `Menu` (line 28).
You can use it in the template to render the menu.
Add the following [`ibexa_render_content_query` function](content_twig_functions.md#ibexa_render_content_query) to the `pagelayout_html.twig` template:

``` html+twig
[[= include_file('code_samples/front/layouts/menu/templates/themes/my_theme/pagelayout.html.twig', 0, 7) =]]
```

Next, add the `templates/themes/<theme_name>/pagelayout_menu.html.twig` template,
which renders the individual items of the menu:

``` html+twig
[[= include_file('code_samples/front/layouts/menu/templates/themes/my_theme/pagelayout_menu.html.twig') =]]
```

## Create a MenuBuilder

To make a more configurable menu, where you select the specific items to render,
use the [KNPMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) that is installed together with the product.

To use it, first create a `MenuBuilder.php` file in `src/Menu`:

``` php hl_lines="20 21 22 26"
[[= include_file('code_samples/front/layouts/menu/src/Menu/MenuBuilder.php') =]]
```

In the builder, you can define items that you want in the menu.
For example, lines 20-22 add a specific Location by using the [`ibexa.url.alias`](url_twig_functions.md#ibexa.url.alias) route.
Line 26 adds a defined system route that leads to the search form.

Next, register the menu builder as a service:

``` yaml
App\Menu\MenuBuilder:
    tags:
        - {name: knp_menu.menu_builder, method: buildMenu, alias: root}
```

Finally, you can render the menu in `pagelayout.html.twig`.
Identify it by the name that you provided in the Menu Builder's `buildMenu()` method:

``` html+twig
[[= include_file('code_samples/front/layouts/menu/templates/themes/my_theme/pagelayout.html.twig', 8, 9) =]]
```
