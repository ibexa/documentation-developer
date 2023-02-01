# Extend storefront

## Built-in menus

With the `ibexa\storefront` package come the following built-in menus:

- Breadcrumbs
- Currency menu
- Language menu
- Region menu
- Taxonomy menu
- User menu

### Breadcrumbs menu

```html+twig
{% set menu = knp_menu_get('ibexa_storefront.menu.breadcrumbs.product', [], {
    'product': product
}) %}

{{ knp_menu_render(menu, {
    template: '@ibexadesign/storefront/knp_menu/breadcrumbs.html.twig',
}) }}
```

### Currency

The currencu menu 

### Language menu

### Region menu

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

## Add menu items

Storefront menus are easily extensible.

You can build menu items based on repository objects with the `\Ibexa\Contracts\Storefront\Menu\ItemFactoryInterface` methods.

The following items are available:

- Content
- Content ID
- Location
- Location ID
- Taxonomy Entry
- Product

