---
description: TODO
editions: lts-update commerce
month_change: true
---

# TODO: Storefront shopping list templates

To integrate the shopping list features to your own online store design, you can

- look at the default shopping list templates for the `standard` theme in
`vendor/ibexa/shopping-list/src/bundle/Resources/views/themes/standard/shopping_list/` directory
- look at their overrides and complements in the [`storefront`](storefront.md) theme at
`vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/shopping_list/`

## TODO: UI components

### "Add to shopping list" widget

The storefront template `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/shopping_list/component/add_to_shopping_list/add_to_shopping_list.html.twig`
can help you integrate the "Add to shopping list" button into your product pages.

```twig
{% include '@ibexadesign/shopping_list/component/add_to_shopping_list/add_to_shopping_list.html.twig' with {
    product_code: product.code,
} %}
```

## Built-in views

Some routes lead to views (when used with `GET` method) through controllers from the `\Ibexa\Bundle\ShoppingList\Controller` namespace.
Each use a template which receives one or several variables, including forms to handle user interactions.

| Route                                    | Route name                   | Controller                           | Template                                      | Available forms / (TODO: other template variables?)                     | Description                                                          |
|------------------------------------------|------------------------------|--------------------------------------|-----------------------------------------------|-------------------------------------------------------------------------|----------------------------------------------------------------------|
| `GET /shopping-list`                     | `ibexa.shopping_list.list`   | `ShoppingListListController`         | `@ibexadesign/shopping_list/list.html.twig`   | `bulk_delete_form`, `filter_form`                                       | List of shopping lists                                               |
| `GET /shopping-list/create`              | `ibexa.shopping_list.create` | `ShoppingListCreateController`       | `@ibexadesign/shopping_list/create.html.twig` | `form`                                                                  | Form to create a new shopping list                                   |
| `GET /shopping-list/{identifier}`        | `ibexa.shopping_list.view`   | `ShoppingListViewController`         | `@ibexadesign/shopping_list/view.html.twig`   | `move_entries_form`, `remove_entries_form`, `clear_form`, `delete_form` | Shopping list display                                                |
| `GET /shopping-list/{identifier}/update` | `ibexa.shopping_list.update` | `ShoppingListUpdateController`       | `@ibexadesign/shopping_list/update.html.twig` | `form`                                                                  | Form to rename a shopping list                                       |
| `GET /shopping-list/add`                 | `ibexa.shopping_list.add`    | `AddProductToShoppingListController` | `@ibexadesign/shopping_list/add.html.twig`    | `forms` (array of forms indexed on product code)                        | List of products with for each the form to add it to a shopping list |

For all those templates (but `add.html.twig`), you'll find two implementations:

- a generic one for the `standard` theme in `vendor/ibexa/shopping-list/src/bundle/Resources/views/themes/standard/`
- a more advanced demo one for the `storefront` theme in `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/`

The `add` route is less interesting, and you should consider using the ["Add to shopping list" widget](#add-to-shopping-list-widget) first.

The following example shows how to link to the shopping list listing page, using a heart icon:

```twig
<a href="{{ path('ibexa.shopping_list.list') }}">
<svg><use xlink:href="{{ ibexa_icon_path('heart') }}"></use></svg>
</a>
```
