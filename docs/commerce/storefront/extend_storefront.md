---
description: Extend Storefront with new menus.
edition: commerce
---

# Extend Storefront

## Built-in menus

With the `ibexa/storefront` package come the following built-in menus:

| Item   | Value     | Description |
|------------|----------|---------|
| [Breadcrumbs](#breadcrumbs-menu)| - | Renders breadcrumbs for content tree root, Taxonomy Entry, product, user settings, and user settings group |
| [Taxonomy](#taxonomy-menu)| - | It can render a menu for product categories or tags |
| Currency| `currency_menu` | Renders a menu to change the active currency |
| Language| `language_menu` | Renders a menu to change the active language |
| Region  | `region_menu`  | Renders a menu to change the active region |

Usage example:

```html_twig
{% set currency_menu = knp_menu_get('ibexa_storefront.menu.currency') %}

{{ knp_menu_render(currency_menu) }}
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

## Generate custom product preview path

By default, the `ProductRenderController` controller passes only the product object for rendering.
You can modify the controller file to make it pass parameters to the [`path`]([[= symfony_doc =]]/reference/twig_reference.html#path) Twig helper function, which is used by the `product_card.html.twig` and `product_card.html.twig` [templates](customize_storefront_layout.md) to generate the user path.
After you modify the controller, it can also pass the following parameters:

- `route` - the route, under which product preview is available.
- `parameters` - parameters to be used, for example, to render the view.
- `is_relative` - Boolean that decides whether the URL is relative or absolute.

Define your own logic in a custom controller.
Refer to the code snippet below and create your own file, for example, `CustomProductRenderController.php`:

``` php
    public function renderAction(ProductInterface $product): Response
    {
        return $this->render('@ibexadesign/storefront/product_card.html.twig', [
            'content' => $product,
            'route' => 'some.path',
            'parameters' => ['some.parameter' => 123],
            'is_relative' => true,
        ]);
    }
```
