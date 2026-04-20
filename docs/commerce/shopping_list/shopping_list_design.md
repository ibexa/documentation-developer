---
description: Learn how to integrate the shopping list features to your own online store design.
editions: lts-update commerce
month_change: false
---

# Shopping list design

To integrate the shopping list features to your own online store design, you can

- look at the default shopping list templates for the `standard` theme in
`vendor/ibexa/shopping-list/src/bundle/Resources/views/themes/standard/shopping_list/` directory
- look at their overrides and complements in the [`storefront` theme](storefront.md) at
`vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/shopping_list/`

## "Add to shopping list" widget

This widget contains a list of shopping lists indicating whether a product belongs to given list and allows to create a new shopping list on the fly.
It's used in the `storefront` theme in several places, embedded within a drop-down menu or a modal.
!["Add to shopping list" belonging menu with "Bikes" selected](img/shopping_list_belonging_2.png "List of shopping lists for a product belonging to a "Bikes" shopping list")

You can use the following Twig and TypeScript components to insert an "Add to shopping list" widget for a product into your storefront:

- `vendor/ibexa/shopping-list/src/bundle/Resources/views/themes/standard/shopping_list/component/add_to_shopping_list/add_to_shopping_list.html.twig` displays a list of shopping lists preceded with checkboxes showing if the product is in it.
- `vendor/ibexa/shopping-list/src/bundle/Resources/public/js/component/add.to.shopping.list.ts` handles the interaction with the list of shopping lists' checkboxes and the new shopping list creation on the fly.
- `vendor/ibexa/shopping-list/src/bundle/Resources/public/js/component/shopping.list.ts` handles the REST API calls.
- `vendor/ibexa/shopping-list/src/bundle/Resources/public/js/component/shopping.lists.list.ts` handles the list of shopping lists.

The following example shows the setup of an "Add to shopping list" widget on a product full view page in the `standard` theme without implying the `storefront` theme.
For a base product, the variants are listed with an instance of the widget to demonstrate that it can be used several time on the same page.

Create an `assets/js/add-to-shopping-list.ts` that initializes the `ShoppingList` object and imports the script handling the widget interactions:

``` ts
[[= include_file('code_samples/shopping_list/add_to_shopping_list/assets/js/add-to-shopping-list.ts') =]]
```

Edit the `webpack.config.js` to enable TypeScript, set the aliases used in `add-to-shopping-list.ts`, and create an entry for it:

``` js hl_lines="5-14"
// […]

[[= include_file('code_samples/shopping_list/add_to_shopping_list/webpack.config.js', 43) =]]
```

Then, you can use the component in your template as in the following example:

```twig hl_lines="4 5 9-11 14"
{% block meta %}
    {{ parent() }}
    {# The CSRF token and SiteAccess are needed for the REST API calls #}
    <meta name="CSRF-Token" content="{{ csrf_token(ibexa_get_rest_csrf_token_intention()) }}"/>
    <meta name="SiteAccess" content="{{ app.request.get('siteaccess').name }}"/>
{% endblock %}
{% block content %}
    {{ product.name }}
    {% include '@ibexadesign/shopping_list/component/add_to_shopping_list/add_to_shopping_list.html.twig' with {
        product_code: product.code,
    } %}
{% endblock %}
{% block javascripts %}
    {{ encore_entry_script_tags('add-to-shopping-list-js') }}
{% endblock %}
```

To have a more complete example, let's continue with a product full view template which could work on a fresh installation.

In `src/Controller/ProductViewController.php`, create a new controller to add the variants to the product view:

``` php hl_lines="24-30"
[[= include_code('code_samples/shopping_list/add_to_shopping_list/src/Controller/ProductViewController.php') =]]
```

In `templates/themes/standard/full/product.html.twig`, create a template to render the product in full view:

``` twig hl_lines="7 8 16-18 31-33 44"
[[= include_file('code_samples/shopping_list/add_to_shopping_list/templates/themes/standard/full/product.html.twig') =]]
```

Because the component uses global variables, it can't be used directly in a macro.

In `config/packages/views.yaml`, configure the controller and template used to render the product full view:

``` yaml hl_lines="7 8"
[[= include_file('code_samples/shopping_list/add_to_shopping_list/config/packages/views.yaml') =]]
```

![](img/add_to_shopping_list_widget.png "Preview of this “Add to shopping list” widget example")

## `ShoppingList` JS class and `ibexaShoppingList` global

The `ShoppingList` class is responsible for handling the shopping lists data and interactions with the REST API.
An object of this class contains the shopping lists and their entries, and has methods to manipulate the shopping lists.

An object of this class can be initialized with the `shoppingList.init()` function only once.
This initialization creates the `window.ibexaShoppingList` global variable pointing to the object.
If you have several scripts needing an instance of `ShoppingList` class, `window.ibexaShoppingList` is the indicator if it has been initialized already and it points to the object you should use.
Preferably initialize an object of class `ShoppingList` on the top of the script, then use `window.ibexaShoppingList` in the next lines.

It has the following methods:

- `createShoppingList(name)` creates a new shopping list, updates the local `window.ibexaShoppingList.shoppingLists` property,
  and returns a [`Promise`](https://developer.mozilla.org/docs/Web/JavaScript/Reference/Global_Objects/Promise) resolving to an array with
    - at index 0, the created shopping list
    - at index 1, the whole `ShoppingList` object with all the user's shopping lists
- `getShoppingLists()` returns the local `window.ibexaShoppingList.shoppingLists` property
- `loadShoppingLists()` loads the shopping lists from the server, then updates the local `window.ibexaShoppingList.shoppingLists` property, and returns it
- `loadShoppingList(list_identifier: string)` returns a `Promise` for the shopping list with the given identifier
- `addShoppingListEntries(list_identifier: string, product_codes: string[])` adds entries to the given shopping list for the given product codes, and returns a `Promise` for the [`Response`](https://developer.mozilla.org/docs/Web/API/Response)
- `removeShoppingListEntries(list_identifier: string, entry_identifiers: string[])` remove from the given shopping list the given entries, and returns a `Promise` resolving to a `Response`

`window.ibexaShoppingList.shoppingLists` has the following data structure:

```js
shoppingLists_Mockup = {
    totalCount: 2,
        count: 2,
        ShoppingList: [
        {
            identifier: "12345678-1234-1234-1234-123456789abc",
            name: "My Wishlist",
            isDefault: true,
            owner: {_href: "/api/ibexa/v2/user/users/…", '_media-type': "application/vnd.ibexa.api.User+json"},
            entries: [
                {
                    identifier: "…",
                    product: {
                        _href: "/api/ibexa/v2/product/catalog/products/PRODUCT_CODE",
                        '_media-type': "application/vnd.ibexa.api.Product+json",
                        code: "PRODUCT_CODE",
                        name: "Product name"
                    },
                    addedAt: "YYYY-MM-DD hh:mm:ss"
                }
            ],
            createdAt: "YYYY-MM-DD hh:mm:ss",
            updatedAt: "YYYY-MM-DD hh:mm:ss"
        },
        {
            identifier: "325d1f8d-877d-40bf-9389-e8eb3e0de58a",
            name: "My own custom list",
            isDefault: false,
            owner: {_href: "/api/ibexa/v2/user/users/…", '_media-type': "application/vnd.ibexa.api.User+json"},
            entries: [
                {
                    identifier: "…",
                    product: {
                        _href: "/api/ibexa/v2/product/catalog/products/ANOTHER_PRODUCT_CODE",
                        '_media-type': "application/vnd.ibexa.api.Product+json",
                        code: "ANOTHER_PRODUCT_CODE",
                        name: "Another product name"
                    },
                    addedAt: "YYYY-MM-DD hh:mm:ss"
                }
            ],
            createdAt: "YYYY-MM-DD hh:mm:ss",
            updatedAt: "YYYY-MM-DD hh:mm:ss"
        }
    ]
};
```

Remember that a `ShoppingList` object like the `window.ibexaShoppingList` has its data updated by the `ShoppingList.createShoppingList` and `ShoppingList.loadShoppingLists` methods.

The following script creates a shopping list, adds a product to it, then refreshes the local `window.ibexaShoppingList.shoppingLists` (as `addShoppingListEntries` method doesn't do it):

```javascript hl_lines="6-8"
if (!window.ibexaShoppingList) {
  throw new Error('ShoppingList object not initialized, window.ibexaShoppingList not defined');
}
let product_code = '<PRODUCT_CODE>';
let shopping_list_name = '<SHOPPING_LIST_NAME>';
window.ibexaShoppingList.createShoppingList(shopping_list_name).then((data) => {
    window.ibexaShoppingList.addShoppingListEntries(data[0].identifier, [product_code]).then(() => {
        window.ibexaShoppingList.loadShoppingLists(); // Refresh local object
    });
});
```

If the "Add to shopping list" widget is used, it could be updated with the following addition to the previous script:

```javascript hl_lines="4-7"
window.ibexaShoppingList.createShoppingList(shopping_list_name).then((data) => {
    let shopping_list_identifier = data[0].identifier;
    window.ibexaShoppingList.addShoppingListEntries(shopping_list_identifier, [product_code]).then(() => {
        window.ibexaShoppingList.loadShoppingLists().then(() => {
            let selector = '.ibexa-sl-add-to-shopping-list[data-product-code="' + product_code + '"] input[type="checkbox"][value="' + shopping_list_identifier + '"]';
            document.querySelector(selector).checked = true; // Check the new list in product's "Add to shopping list" widget
        });
    });
});
```

## JavaScript events

### Shopping lists data changed event

The `ibexa-shopping-list:shopping-lists-data-changed` event is dispatched by the `document.body`

- on `ShoppingList.init()` (and the `window.ibexaShoppingList` global variable is set)
- on `ShoppingList.createShoppingList()` (and the `window.ibexaShoppingList` global variable is updated)
- on `ShoppingList.addShoppingListEntries()`
- on `ShoppingList.removeShoppingListEntries()`

```javascript
document.body.addEventListener('ibexa-shopping-list:shopping-lists-data-changed', (event) => {
    console.log(event, window.ibexaShoppingList);
})
```

### Prepare request event

The `ibexa-shopping-list:prepare-request` event is dispatched by the `document` before each REST API call,
with the request details in the event's `detail` property.

```javascript
document.addEventListener('ibexa-shopping-list:prepare-request', (event) => {
    console.log(event, event.detail.request);
})
```

## Built-in views

Some routes lead to views (when used with `GET` method) through controllers from the `\Ibexa\Bundle\ShoppingList\Controller` namespace.
Each uses a template which receives one or several variables, including forms to handle user interactions.

| Route path,<br>name,<br>and controller                                                                                  | Template                                      | Available variables                                                                                                                                                                                                    | Description                                                          |
|-------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------|
| `GET /shopping-list`<br><nobr>`ibexa.shopping_list.list`</nobr><br>`ShoppingListListController`                         | `@ibexadesign/shopping_list/list.html.twig`   | <nobr>`shopping_lists` (`Pagerfanta`),</nobr><br><nobr>`bulk_delete_form`,</nobr><br>`filter_form`                                                                                                                     | List of shopping lists                                               |
| `GET /shopping-list/create`<br><nobr>`ibexa.shopping_list.create`</nobr><br>`ShoppingListCreateController`              | `@ibexadesign/shopping_list/create.html.twig` | `form`                                                                                                                                                                                                                 | Form to create a new shopping list                                   |
| `GET /shopping-list/{identifier}`<br><nobr>`ibexa.shopping_list.view`</nobr><br>`ShoppingListViewController`            | `@ibexadesign/shopping_list/view.html.twig`   | <nobr>`move_entries_form`,</nobr><br><nobr>`remove_entries_form`,</nobr><br>`clear_form`,<br>`delete_form`                                                                                                             | Shopping list display                                                |
| `GET /shopping-list/{identifier}/update`<br><nobr>`ibexa.shopping_list.update`</nobr><br>`ShoppingListUpdateController` | `@ibexadesign/shopping_list/update.html.twig` | `shopping_list`,<br>`form`                                                                                                                                                                                             | Form to rename a shopping list                                       |
| `GET /shopping-list/add`<br><nobr>`ibexa.shopping_list.add`</nobr><br>`AddProductToShoppingListController`              | `@ibexadesign/shopping_list/add.html.twig`    | `products` ([`ProductListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductListInterface.html)),<br>`forms` (associative array of forms indexed on product code) | List of products with for each the form to add it to a shopping list |

For all those templates (except `add.html.twig`), you'll find two implementations:

- a generic one for the `standard` theme in `vendor/ibexa/shopping-list/src/bundle/Resources/views/themes/standard/`
- a more advanced demo one for the `storefront` theme in `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/`

Instead of using the `add` route, you should consider using the ["Add to shopping list" widget](#add-to-shopping-list-widget) first.

The following example shows how to link to the shopping list listing page, using a heart icon:

```twig
<a href="{{ path('ibexa.shopping_list.list') }}">
<svg><use xlink:href="{{ ibexa_icon_path('heart') }}"></use></svg>
</a>
```

The `\Ibexa\Bundle\Storefront\EventSubscriber\ShoppingList\DetailsViewSubscriber` passes an additional `selected_entries_form` variable to the template.
This form allows to have "Add to cart" button for selected entries on top of the shopping list view in `storefront` theme
through `vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/shopping_list/view.html.twig`.

## User menu

The `\Ibexa\Bundle\Storefront\EventSubscriber\ShoppingList\UserMenuSubscriber` is responsible for
adding the "Shopping lists" item between "Orders" and "Change password" to the user menu
previously initiated by the `\Ibexa\Bundle\Storefront\Menu\Builder\UserMenuBuilder`.
You can look at how this subscriber tests that the user isn't anonymous
and then has the [`shopping_list/view` policy](policies.md#shopping-lists) ([`\Ibexa\Contracts\ShoppingList\Permission\Policy\ShoppingList\View`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ShoppingList-Permission-Policy-ShoppingList-View.html))
before adding the "Shopping lists" item.
