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

| Route path and name                                                      | Controller                           | Template                                      | Available variables                                                                                        | Description                        |
|--------------------------------------------------------------------------|--------------------------------------|-----------------------------------------------|------------------------------------------------------------------------------------------------------------|------------------------------------|
| `GET /shopping-list`<br>`ibexa.shopping_list.list`                       | `ShoppingListListController`         | `@ibexadesign/shopping_list/list.html.twig`   | <nobr>`shopping_lists` (`Pagerfanta`),</nobr><br><nobr>`bulk_delete_form`,</nobr><br>`filter_form`         | List of shopping lists             |
| `GET /shopping-list/create`<br>`ibexa.shopping_list.create`              | `ShoppingListCreateController`       | `@ibexadesign/shopping_list/create.html.twig` | `form`                                                                                                     | Form to create a new shopping list |
| `GET /shopping-list/{identifier}`<br>`ibexa.shopping_list.view`          | `ShoppingListViewController`         | `@ibexadesign/shopping_list/view.html.twig`   | <nobr>`move_entries_form`,</nobr><br><nobr>`remove_entries_form`,</nobr><br>`clear_form`,<br>`delete_form` | Shopping list display              |
| `GET /shopping-list/{identifier}/update`<br>`ibexa.shopping_list.update` | `ShoppingListUpdateController`       | `@ibexadesign/shopping_list/update.html.twig` | `shopping_list`,<br>`form`                                                                                 | Form to rename a shopping list     |
| `GET /shopping-list/add`<br>`ibexa.shopping_list.add`                    | `AddProductToShoppingListController` | `@ibexadesign/shopping_list/add.html.twig`    | `products` ([`ProductListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductListInterface.html)),<br>`forms` (associative array of forms indexed on product code) | List of products with for each the form to add it to a shopping list |

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

The `\Ibexa\Bundle\Storefront\EventSubscriber\ShoppingListViewSubscriber` passes an additional `selected_entries_form` variable to the template.
This form allows to have "Add to cart" button for selected entries on top of the shopping list view in `storefront` theme
through `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/shopping_list/view.html.twig`.

## User menu

The `\Ibexa\Bundle\Storefront\EventSubscriber\ShoppingList\UserMenuSubscriber` is responsible for
adding the "Shopping lists" item between "Orders" and "Change password" to the user menu
previously initiated by the `\Ibexa\Bundle\Storefront\Menu\Builder\UserMenuBuilder`.
You can look at how this subscriber tests that the user isn't anonymous
and then has the `shopping_list/view` policy (`\Ibexa\Contracts\ShoppingList\Permission\Policy\ShoppingList\View`)
before adding the "Shopping lists" item.
