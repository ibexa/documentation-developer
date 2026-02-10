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

Some Twig and TypeScript components can help you insert an "Add to shopping list" widget for a product:

- `vendor/ibexa/shopping-list/src/bundle/Resources/views/themes/standard/shopping_list/component/add_to_shopping_list/add_to_shopping_list.html.twig` displays a list of shopping lists preceded with checkboxes showing if the product is in.
- `vendor/ibexa/shopping-list/src/bundle/Resources/public/js/component/add.to.shopping.list.ts` handles the interaction with the list of shopping lists' checkboxes and the new shopping list creation on the fly.
- `vendor/ibexa/shopping-list/src/bundle/Resources/public/js/component/shopping.list.ts` handles the REST API calls.
- `vendor/ibexa/shopping-list/src/bundle/Resources/public/js/component/shopping.lists.list.ts` handles the list of shopping lists.

`assets/js/add-to-shopping-list.ts`:
```ts
import ShoppingList from '@ibexa-shopping-list/src/bundle/Resources/public/js/component/shopping.list'; // Shopping list service
import { AddToShoppingList } from '@ibexa-shopping-list/src/bundle/Resources/public/js/component/add.to.shopping.list'; // The Add to shopping list interaction
import { ShoppingListsList } from '@ibexa-shopping-list/src/bundle/Resources/public/js/component/shopping.lists.list'; // List of all user's shopping lists

(function (global: Window, doc: Document) {
    const shoppingList = new ShoppingList();
    shoppingList.init(); // Fetch user's shopping lists

    const addToShoppingListsNodes = doc.querySelectorAll<HTMLDivElement>('.ibexa-sl-add-to-shopping-list');
    addToShoppingListsNodes.forEach((addToShoppingListNode) => {
        const addToShoppingList = new AddToShoppingList({ node: addToShoppingListNode, ListClass: ShoppingListsList });

        addToShoppingList.init();
    });
})(window, window.document);
```

`webpack.config.js` bottom part:
```js
//Encore.addEntry('app', './assets/app.js');
Encore
    .enableTypeScriptLoader()
    .addAliases({
        '@ibexa-shopping-list': path.resolve('./vendor/ibexa/shopping-list'),
    })
    .addEntry('add-to-shopping-list-js', [
        path.resolve(__dirname, './assets/js/add-to-shopping-list.ts'),
    ])
;

const projectConfig = Encore.getWebpackConfig();

projectConfig.name = 'app';

module.exports = [...customConfigs, projectConfig];
```

Then, you're able to use the component in your template with something like the following:

```twig
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

To have a more complete example, lets continue with a product full view template which could work on a fresh installation.

`src/Controller/ProductViewController.php` to add the variants to the product view:
```php
<?php

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\Iterator\BatchIterator;
use Ibexa\Contracts\ProductCatalog\Iterator\BatchIteratorAdapter\ProductVariantFetchAdapter;
use Ibexa\Contracts\ProductCatalog\Local\LocalProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use Ibexa\Core\MVC\Symfony\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductViewController extends AbstractController
{
    public function __construct(private LocalProductServiceInterface $productService)
    {
    }

    public function viewAction(Request $request, ContentView $view): View
    {
        $product = $this->productService->getProductFromContent($view->getContent());
        if ($product->isBaseProduct()) {
            $adapter = new ProductVariantFetchAdapter(
                $this->productService,
                $product,
                new ProductVariantQuery(),
            );

            $view->addParameters([
                'variants' => new BatchIterator($adapter),
            ]);

            return $view;
        }
    }
}
```

`config/packages/views.yaml` to associate the controller and template to the product full view:
```yaml
ibexa:
    system:
        default:
            content_view:
                full:
                    product:
                        controller: 'App\Controller\ProductViewController::viewAction'
                        template: '@ibexadesign/full/product.html.twig'
                        match:
                            '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\IsProduct': true
```

`templates/themes/standard/full/product.html.twig`:
```twig+html
{% extends '@ibexadesign/pagelayout.html.twig' %}

{% set product = content|ibexa_get_product %}

{% block meta %}
    {% set token = csrf_token ?? csrf_token(ibexa_get_rest_csrf_token_intention()) %}
    <meta name="CSRF-Token" content="{{ token }}"/>
    <meta name="SiteAccess" content="{{ app.request.get('siteaccess').name }}"/>
{% endblock %}

{% block content %}
    {{ ibexa_content_name(content) }}
    {{ product.code }}
    {% if not product.isBaseProduct() and can_view_shopping_list and can_edit_shopping_list %}
        {% set component %}
            {% include '@ibexadesign/shopping_list/component/add_to_shopping_list/add_to_shopping_list.html.twig' with {
                product_code: product.code,
            } %}
        {% endset %}
        {{ _self.add_to_shopping_list(product, component) }}
    {% endif %}

    {% if product.isBaseProduct() %}
        <ul>
            {% for variant in variants %}
                <li>
                    {{ variant.name }}
                    {{ variant.code }}
                    {% if can_view_shopping_list and can_edit_shopping_list %}
                        {% set component %}
                            {% include '@ibexadesign/shopping_list/component/add_to_shopping_list/add_to_shopping_list.html.twig' with {
                                product_code: variant.code,
                            } %}
                        {% endset %}
                        {{ _self.add_to_shopping_list(variant, component) }}
                    {% endif %}
                </li>
            {% endfor %}
        </ul>
    {% endif %}
{% endblock %}

{% block javascripts %}
    {{ encore_entry_script_tags('add-to-shopping-list-js') }}
{% endblock %}

{% macro add_to_shopping_list(product, component) %}
    {% set widget_id = 'add-to-shopping-list-' ~ product.code|slug %}
    <button
        onclick="(function(){let e=document.getElementById('{{ widget_id }}'); e.style.display=('none'===window.getComputedStyle(e).display)?'block':'none';})()">
        Add to shopping list
    </button>
    <div id="{{ widget_id }}" style="display: none;">
        {{ component }}
    </div>
{% endmacro %}
```
Because the component uses some global variables, it can't be used directly in the macro.

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
