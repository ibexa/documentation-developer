# Add navigation menu

Enrich you site front with a menu displaying selected content items.

To add a navigation menu to your website, prepare a general layout template in a `templates/themes/<theme_name>/pagelayout.html.twig` file.

This template can contain things such as header, menu, footer, and [assets](../../assets/index.md) for the whole site, and all other templates [extend](../../templates/templates/index.md#connecting-templates) it.

To select items that should be rendered in the menu, you can use one of the following ways:

- create a [query](#render-menu-using-a-query)
- create a [MenuBuilder](#create-a-menubuilder)

## Render menu using a query

To create a menu that contains a specific set of content items, for example all content under the root location, use a [Query Type](../../queries_and_controllers/content_queries/index.md).

First, in `src/QueryType`, create a custom `MenuQueryType.php` file that queries for all items that you want in the menu:

```php
<?php declare(strict_types=1);

namespace App\QueryType;

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Core\QueryType\QueryType;

class MenuQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        $criteria = new Query\Criterion\LogicalAnd([
            new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE),
            new Query\Criterion\ParentLocationId(2),
        ]);
        $options = [
            'filter' => $criteria,
            'sortClauses' => [
                new SortClause\Location\Priority(LocationQuery::SORT_ASC),
            ],
        ];

        return new LocationQuery($options);
    }

    public static function getName()
    {
        return 'Menu';
    }

    public function getSupportedParameters()
    {
        return [];
    }
}
```

In this case, it queries for all visible children of location `2`, the root location, (lines 15-16) and renders them in order according to their location priority.

The Query Type has the name `Menu` (line 28). You can use it in the template to render the menu. Add the following [`ibexa_render_content_query` function](../../twig_function_reference/content_twig_functions/index.md#ibexa_render_content_query) to the `pagelayout_html.twig` template:

```html+twig
{{ ibexa_render_content_query({
    'query': {
        'query_type': 'Menu',
        'assign_results_to': 'menuItems'
    },
    'template': '@ibexadesign/pagelayout_menu.html.twig',
}) }}
```

Next, add the `templates/themes/<theme_name>/pagelayout_menu.html.twig` template, which renders the individual items of the menu:

```html+twig
{% if menuItems is defined and menuItems is not empty %}
    {% for item in menuItems %}
        <li><a href="{{ ibexa_path(item.valueObject) }}">{{ ibexa_content_name(item.valueObject.contentInfo) }}</a></li>
    {% endfor %}
{% endif %}
```

## Create a MenuBuilder

To make a more configurable menu, where you select the specific items to render, use the [KNPMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) that is installed together with the product.

To use it, first create a `MenuBuilder.php` file in `src/Menu`:

```php
<?php declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    public function __construct(private readonly FactoryInterface $factory)
    {
    }

    public function buildMenu(): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Home', ['route' => 'ibexa.url.alias', 'routeParameters' => [
            'locationId' => 2,
        ]]);
        $menu->addChild('Blog', ['route' => 'ibexa.url.alias', 'routeParameters' => [
            'locationId' => 67,
        ]]);
        $menu->addChild('Search', ['route' => 'ibexa.search']);

        return $menu;
    }
}
```

In the builder, you can define items that you want in the menu. For example, lines 21-23 add a specific location by using the [`ibexa.url.alias`](../../twig_function_reference/url_twig_functions/index.md#ibexaurlalias) route. Line 27 adds a defined system route that leads to the search form.

Next, register the menu builder as a service:

```yaml
services:
    App\Menu\MenuBuilder:
        tags:
            - {name: knp_menu.menu_builder, method: buildMenu, alias: root}
```

Finally, you can render the menu in `pagelayout.html.twig`. Identify it by the name that you provided in the Menu Builder's `buildMenu()` method:

```html+twig
{{ knp_menu_render('root') }}
```
