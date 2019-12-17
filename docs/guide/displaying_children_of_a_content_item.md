# Displaying  Content item children

One of the basic design tasks you may need to complete when creating your website is configuring one page to display all of its children.
For example you can configure a blog displaying all blog posts or a folder showing all articles it contains.

There are two ways to make a Content item display its children:

1. [Using the Query Controller](#using-the-query-controller)
1. [Using a Custom Controller](#using-a-custom-controller)

This procedure demonstrates how to use both these methods to display all children of a Content item with the Content Type Folder.

## Using the Query Controller

The Query Controller is a pre-defined custom content view Controller that runs a Repository Query.

If you need to create a simple Query, it is easier to use the Query Controller than to build a completely custom one, as you will not have to write custom PHP code. 
Like with a [Custom Controller](#using-a-custom-controller), however, you will be able to use properties of the viewed Content item or Location as parameters.

The main file in this case is an `src/QueryType/LocationChildrenQueryType.php` file which generates a Query that retrieves the children of the current Location.

``` php
<?php

namespace App\QueryType;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\ParentLocationId;
use eZ\Publish\Core\QueryType\QueryType;

class LocationChildrenQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        return new LocationQuery([
            'filter' => new ParentLocationId($parameters['parentLocationId']),
        ]);
    }

    public function getSupportedParameters()
    {
        return ['parentLocationId'];
    }

    public static function getName()
    {
        return 'LocationChildren';
    }
}
```

Next, in your [standard view configuration](../guide/content_rendering.md#configuring-views-the-viewprovider) file, under `content_view`, add a section that indicates when this Controller will be used. It is similar to regular view config, but contains additional information:

``` yaml
folder:
    controller: ez_query:locationQueryAction
    template: full/folder.html.twig
    match:
        Identifier\ContentType: folder
    params:
        query:
            query_type: LocationChildren
            parameters:
                parentLocationId: '@=location.id'
            assign_results_to: items
```

In this case the `controller` key points to the Query Controller's `locationQuery` action. `assign_results_to` identifies the parameter containing all the retrieved children that will later be used in the templates, like here in `templates/full/folder.html.twig`:

``` html+twig
<h1>{{ ez_content_name(content) }}</h1>

{% for item in items.searchHits %}
  <h2><a href={{ path('ez_urlalias', {'contentId': item.valueObject.contentInfo.id}) }}>{{ ez_content_name(item.valueObject.contentInfo) }}</a></h2>
{% endfor %}
```

This template makes use of the `items` specified in `assign_results_to` to list every child of the folder.

## Using a Custom Controller

There are three different ways of using a Custom Controller. See [Custom Controller](../guide/controllers.md#custom-rendering-logic) section.

In this case, we will be using the Custom Controller alongside the built-in ViewController.

Configuring for the use of a Custom Controller starts with pointing to it in your standard view configuration (which you can keep in `ezplatform.yaml` or as a separate file, for example `views.yaml`):

``` yaml
folder:
    controller: App\Controller\FolderController::showAction
    template: full/folder.html.twig
    match:
        Identifier\ContentType: folder
```

You can see here the standard view config consisting of the `template` and `match` keys.
Under the `controller` key, you need to provide the path to the Controller and the action.
They are defined in `src/Controller/FolderController.php`:

``` php
<?php

namespace App\Controller;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use App\Criteria\Children;

class FolderController
{

    /** @var \eZ\Publish\API\Repository\SearchService */
    protected $searchService;

    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface */
    protected $configResolver;

    /** @var \App\Criteria\Children */
    protected $childrenCriteria;

    /**
     * @param \eZ\Publish\API\Repository\SearchService $searchService
     * @param \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver
     * @param \App\Criteria\Children $childrenCriteria
     */
    public function __construct(
        SearchService $searchService,
        ConfigResolverInterface $configResolver,
        Children $childrenCriteria
    ) {
        $this->searchService = $searchService;
        $this->configResolver = $configResolver;
        $this->childrenCriteria = $childrenCriteria;
    }

    /**
     * Displays blog posts and gallery images on home page.
     *
     * @param \eZ\Publish\Core\MVC\Symfony\View\ContentView $view
     *
     * @return \eZ\Publish\Core\MVC\Symfony\View\ContentView
     */
    public function showAction(ContentView $view)
    {
        $view->addParameters([
            'items' => $this->fetchItems($view->getLocation(), 25),
        ]);
        return $view;
    }

    private function fetchItems($location, $limit)
    {
        $languages = $this->configResolver->getParameter('languages');
        $query = new Query();

        $query->query = $this->childrenCriteria->generateChildCriterion($location, $languages);
        $query->performCount = false;
        $query->limit = $limit;
        $query->sortClauses = [
            new SortClause\DatePublished(Query::SORT_DESC),
        ];
        $results = $this->searchService->findContent($query);
        $items = [];
        foreach ($results->searchHits as $item) {
            $items[] = $item->valueObject;
        }
        return $items;
    }

}
```

As you can see, this Controller makes use of the `generateChildCriterion`,
which means you need to provide an `src/Criteria/Children.php` file containing this function:

``` php
<?php

namespace App\Criteria;

use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class Children
{
    /**
     * Generate criterion list to be used to fetch sub-items.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location location of the root
     * @param string[] $languages array of languages
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\Criterion
     */
    public function generateChildCriterion(Location $location, array $languages = [])
    {
        return new Criterion\LogicalAnd([
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
            new Criterion\ParentLocationId($location->id),
            new Criterion\Subtree($location->pathString),
            new Criterion\LanguageCode($languages),
        ]);
    }
}
```

Next, you must register these two services in `config/services.yaml`:

``` yaml
services:
    app.criteria.children:
        class: App\Criteria\Children

    App\Controller\FolderController:
        class: App\Controller\FolderController
        arguments:
            - '@ezpublish.api.service.search'
            - '@ezpublish.config.resolver'
            - '@app.criteria.children'
        tags:
            - { name: controller.service_arguments }
```

Finally, let's use the Controller in a `templates/full/folder.html.twig` template:

``` html+twig
<h1>{{ ez_content_name(content) }}</h1>

{% for item in items %}
  <h2><a href={{ path('ez_urlalias', {'contentId': item.contentInfo.id}) }}>{{ ez_content_name(item) }}</a></h2>
{% endfor %}
```

This template makes use of the `items` specified in the Controller file to list every child of the folder.
