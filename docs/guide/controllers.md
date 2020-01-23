# Controllers

## Custom rendering logic

In some cases, displaying a Content item/Location via the built-in `ViewController` is not sufficient to show everything you want. In such cases you may want to **use your own custom logic** to display the current Content item/Location instead.

Typical use cases include access to:

- Settings (coming from `ConfigResolver` or `ServiceContainer`)
- Current Content item's `ContentType` object
- Current Location's parent
- Current Location's children count
- Main Location and alternative Locations for the current Content item
- etc.

There are three ways in which you can apply a custom logic:

- [Configure a custom view controller](#enriching-viewcontroller-with-a-custom-controller) alongside regular matcher rules (**recommended**).
- [Add a Symfony Response listener](#adding-a-listener) to add custom logic to all responses.
- [**Override**](#using-only-your-custom-controller) the built-in `ViewController` with the custom controller in a specific situation.

!!! tip "Permissions for custom controllers"

    See [permission documentation](permissions.md#permissions-for-custom-controllers) for information
    about access control for custom controllers.

### Enriching ViewController with a custom controller

**This is the recommended way of using a custom controller**

To use your custom controller on top of the built-in `ViewController` you need to point to both the controller and the template in the configuration, for example:

``` yaml
#ezplatform.yaml
ezplatform:
    system:
        default:
            content_view:
                full:
                    article:
                        controller: App\Controller\DefaultController::articleViewEnhancedAction
                        template: full/article.html.twig
                        match:
                            Identifier\ContentType: [article]
```

With this configuration, the following controller will forward the request to the built-in `ViewController` with some additional parameters:

``` php
<?php

namespace App\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function articleViewEnhancedAction(ContentView $view)
    {
        // Add custom parameters to existing ones.
        $view->addParameters(['myCustomVariable' => "Hey, I'm a custom message!"]);

        // If you wish, you can also easily access Location and Content objects
        // $location = $view->getLocation();
        // $content = $view->getContent();

        // Set custom header for the Response
        $response = new Response();
        $response->headers->add(['X-Hello' => 'World']);
        $view->setResponse($response);

        return $view;
    }
}
```

These parameters can then be used in templates, for example:

``` html+twig
<!--article.html.twig-->
{% extends no_layout ? view_base_layout : "pagelayout.html.twig" %}

{% block content %}
    <h1>{{ ez_render_field( content, 'title' ) }}</h1>
    <h2>{{ myCustomVariable }}</h2>
    {{ ez_render_field( content, 'body' ) }}
{% endblock %}
```

### Adding a listener

One way to add custom logic to all responses is to use your own listener. Please refer to the [Symfony documentation](https://symfony.com/doc/4.3/event_dispatcher/before_after_filters.html#after-filters-with-the-kernel-response-event) for the details on how to achieve this.

### Using only your custom controller

If you want to apply only your custom controller **in a given match situation** and not use the `ViewController` at all, in the configuration you need to indicate the controller, but no template, for example:

``` yaml
ezplatform:
    system:
        default:
            content_view:
                full:
                    folder:
                        controller: App\Controller\DefaultController::viewFolderAction
                        match:
                            Identifier\ContentType: [folder]
                            Identifier\Section: [standard]
```

In this example, as the `ViewController` is not applied, the custom controller takes care of the whole process of displaying content, including pointing to the template to be used (in this case, `full/custom_controller_folder.html.twig`):

``` php
<?php

namespace App\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;

class DefaultController extends Controller
{
    public function viewFolderAction(ContentView $view)
    {
        $location = $view->getLocation();
        $content = $view->getContent();

        $response = $this->render(
            'full/custom_controller_folder.html.twig',
            [
                'location' => $location,
                'content' => $content,
                'foo' => 'Hey world!!!',
                'osTypes' => ['osx', 'linux', 'windows']
            ]
        );

        // Set custom header for the Response
        $response->headers->add(['X-Hello' => 'World']);

        return $response;
    }
}
```

Here again custom parameters can be used in the template, e.g.:

``` html+twig
{% extends "pagelayout.html.twig" %}

{% block content %}
<h1>{{ ez_render_field( content, 'name' ) }}</h1>
    <h1>{{ foo }}</h1>
    <ul>
    {% for os in osTypes %}
        <li>{{ os }}</li>
    {% endfor %}
    </ul>
{% endblock %}
```

## Query controller

The Query controller is a predefined custom content view controller that runs a repository Query.

You can use it as a custom controller in a view configuration, [alongside match rules](#enriching-viewcontroller-with-a-custom-controller). It can use properties of the viewed Content item or Location as parameters to the Query.

The Query controller makes it easy to retrieve content without writing custom PHP code and to display the results in a template. Example use cases include:

- List of Blog posts in a Blog
- List of Images in a Gallery

### Usage example

This example assumes a "Blog" container that contains a set of "Blog post" items. The goal is, when viewing a Blog, to list the Blog posts it contains.

Four items are required:

- a `LocationChildren` QueryType - It will generate a Query retrieving the children of a given Location id
- a View template - It will render the Blog, and list the Blog posts it contains
- a `content_view` configuration - It will instruct Platform, when viewing a Content item of type Blog, to use the Query Controller, the view template, and the `LocationChildren` QueryType. It will also map the id of the viewed Blog to the QueryType parameters, and set which Twig variable the results will be assigned to.
- [service registration of the QueryType](#registering-the-querytype-into-the-service-container)

#### The LocationChildren QueryType

QueryTypes are described in more detail in the [next section](#querytype-objects). In short, a QueryType can build a Query object, optionally based on a set of parameters. The following example will build a Query that retrieves the sub-items of a Location:

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

#### The `content_view` configuration

We now need a view configuration that matches Content items of type "Blog", and uses the QueryController to fetch the blog posts:

``` yaml
ezplatform:
      system:
            site_group:
                content_view:
                    full:
                        blog:
                            controller: ez_query:locationQueryAction
                            template: content/view/full/blog.html.twig
                            match:
                                Identifier\ContentType: "blog"
                            params:
                                query:
                                    query_type: LocationChildren
                                    parameters:
                                        parentLocationId: '@=location.id'
                                    assign_results_to: blog_posts
```

The view's controller action is set to the QueryController's `locationQuery` action (`ez_query:locationQueryAction`). Other actions are available that run a different type of search (contentInfo or content).

The QueryController is configured in the `query` array, inside the `params` of the `content_view` block:

- `query_type` specifies the QueryType to use, based on its name.
- `parameters` is a hash where parameters from the QueryType are set. Arbitrary values can be used, as well as properties from the currently viewed [Location](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Location.php) and [ContentInfo](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentInfo.php). In that case, the id of the currently viewed Location is mapped to the QueryType's `parentLocationId` parameter: `parentLocationId: "@=location.id"`
- `assign_results_to` sets which Twig variable the search results will be assigned to.

#### The view template

Results from the search are assigned to the `blog_posts` variable as a `SearchResult` object. In addition, since the standard ViewController is used, the currently viewed `location` and `content` are also available.

``` yaml
<h1>{{ ez_content_name(content) }}</h1>

{% for blog_post in blog_posts.searchHits %}
  <h2>{{ ez_content_name(blog_post.valueObject.contentInfo) }}</h2>
{% endfor %}
```

### Configuration details

#### `controller`

Following Controller actions are available:

- `locationQueryAction` runs a Location Search
- `contentQueryAction` runs a content Search
- `contentInfoQueryAction` runs a ContentInfo search
- `pagingQueryAction` returns a `PagerFanta` object and can be used to quickly [paginate query results](#paginating-with-querytypes)

See the [Search](search.md) documentation page for more details about different types of search.

#### `params`

The Query is configured in a `query` hash in `params`, you could specify the QueryType name, additional parameters and the Twig variable that you will assign the results to for use in the template.

- `query_type` - Name of the Query Type that will be used to run the query, defined by the class name.
- `parameters` - Query Type parameters that can be provided in two ways:
        1. As scalar values, for example an identifier, an ID, etc.
        1. Using the Expression language. This simple script language, similar to Twig syntax, lets you write expressions that get value from the current Content item and/or Location:
            - For example, `@=location.id` will be evaluated to the currently viewed Location's ID.`content`, `location` and `view` are available as variables in expressions.
- `assign_results_to`
    - This is the name of the Twig variable that will be assigned the results.
    - Note that the results are the SearchResult object returned by the SearchService.

#### QueryType objects

QueryType is an object that builds a Query. It is different from [Public API queries](../api/public_php_api.md).

To make a new QueryType available to the Query Controller, you need to create a PHP class that implements the QueryType interface, then register it as such in the Service Container.

For more information about the [Service Container on its documentation page](service_container.md).

### The QueryType interface

The PHP QueryType interface describes three methods:

1.  `getQuery()`
2.  `getSupportedParameters()`
3.  `getName()`

``` php
interface QueryType
{
 /**
 * Builds and returns the Query object
 *
 * The Query can be either a content or a Location one.
 *
 * @param array $parameters A hash of parameters that will be used to build the Query
 * @return \eZ\Publish\API\Repository\Values\Content\Query
 */
 public function getQuery(array $parameters = []);

 /**
 * Returns an array listing the parameters supported by the QueryType
 * @return array
 */
 public function getSupportedParameters();

 /**
 * Returns the QueryType name
 * @return string
 */
 public static function getName();
}
```

#### Parameters

A QueryType may accept parameters, including string, array and other types, depending on the implementation. They can be used in any way, such as:

- customizing an element's value (limit, Content Type identifier, etc.)
- conditionally adding/removing criteria from the query
- setting the limit/offset

The implementations should use Symfony's `OptionsResolver` for parameter handling and resolution.

### QueryType example: latest content

This QueryType returns a Query that searches for **the 10 last published Content items, ordered by reverse publishing date**.
It accepts an optional `type` parameter that can be set to a Content Type identifier:

``` php
<?php
namespace App\QueryType;

use eZ\Publish\Core\QueryType\QueryType;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query;

class LatestContentQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        $criteria[] = new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE);
        if (isset($parameters['type'])) {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier($parameters['type']);
        }
        // 10 is the default limit we set, but you can have one defined in the parameters
        return new LocationQuery([
            'filter' => new Query\Criterion\LogicalAnd($criteria),
            'sortClauses' => [new Query\SortClause\DatePublished()],
            'limit' => isset($parameters['limit']) ? $parameters['limit'] : 10,
        ]);
    }
    public static function getName()
    {
        return 'LatestContent';
    }
    /**
     * Returns an array listing the parameters supported by the QueryType.
     * @return array
     */
    public function getSupportedParameters()
    {
        return ['type', 'limit'];
    }
}
```

### Naming of QueryTypes

Each QueryType is named after what is returned by `getName()`. **Names must be unique.** A warning will be thrown during compilation if there is a conflict, and the resulting behavior will be unpredictable.

QueryType names should use a unique namespace, in order to avoid conflicts with other bundles. We recommend that the name is prefixed with the bundle's name, e.g.: `AcmeBundle:LatestContent`. A vendor/company's name could also work for QueryTypes that are reusable throughout projects, e.g.: `Acme:LatestContent`.

### Registering the QueryType into the service container

QueryTypes must be registered as Symfony Services and implement the `eZ\Publish\Core\QueryType\QueryType` interface.
A `QueryType` service is registered automatically when `autoconfigure: true` is set either for that service or in `_defaults`.

!!! tip

    In the default eZ Platform installation services are autoconfigured by default for the `App` namespace,
    so no additional registration is required.

Otherwise, you can register your QueryType with a service tag:

``` yaml
App\QueryType\LatestContent:
    tags:
        - { name: ezpublish.query_type, alias: LatestContent }
```

### Paginating with QueryTypes

Using the `ez_query:pagingQueryAction` you can quickly get paginated results of a query:

``` yaml hl_lines="4 13"
content_view:
    full:
        folder:
            controller: ez_query:pagingQueryAction
            template: full/folder.html.twig
            match:
                Identifier\ContentType: folder
            params:
                query:
                    query_type: LocationChildren
                    parameters:
                        parentLocationId: '@=location.id'
                    limit: 5
                    assign_results_to: items
```

`limit` defines how many query results are listed on a page.

!!! tip

    See [Content view configuration](#the-content_view-configuration) for details on this configuration.

Pagination controls are provided in the `pagerfanta` Twig function:

``` html+twig hl_lines="4"
{% for item in items %}
    <h2><a href={{ path('ez_urlalias', {'contentId': item.valueObject.contentInfo.id}) }}>{{ ez_content_name(item.valueObject.contentInfo) }}</a></h2>
{% endfor %}
{{ pagerfanta( items, 'ez', {'routeName': location } ) }}
```

### The OptionsResolverBasedQueryType abstract class

An abstract class based on Symfony's `OptionsResolver` makes the implementation of QueryTypes with parameters easier.

It provides final implementations of `getQuery()` and `getDefinedParameters()`.

A `doGetQuery()` method must be implemented instead of `getQuery()`. It is called with the parameters processed by the OptionsResolver, meaning that the values have been validated, and default values have been set.

In addition, the `configureOptions(OptionsResolver $resolver)` method must configure the OptionsResolver.

The LatestContentQueryType from the [example above](#querytype-example-latest-content) can benefit from the abstract implementation:

- validate that `type` is a string, but make it optional
- validate that `limit` is an int, with a default value of 10

!!! note

    For further information see the [Symfony's Options Resolver documentation page](http://symfony.com/doc/4.3/components/options_resolver.html)

``` php
<?php

namespace App\QueryType;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\Core\QueryType\OptionsResolverBasedQueryType;
use eZ\Publish\Core\QueryType\QueryType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionsBasedLatestContentQueryType extends OptionsResolverBasedQueryType implements QueryType
{
    protected function doGetQuery(array $parameters)
    {
        $criteria= [
            new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE)
        ];
        if (isset($parameters['type'])) {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier($parameters['type']);
        }

        return new LocationQuery([
            'filter' => new Query\Criterion\LogicalAnd($criteria),
            'sortClauses' => [
                new Query\SortClause\DatePublished()
            ],
            'limit' => $parameters['limit'],
        ]);
    }

    public static function getName()
    {
        return 'LatestContent';
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(['type', 'limit']);
        $resolver->setAllowedTypes('type', 'string');
        $resolver->setAllowedTypes('limit', 'int');
        $resolver->setDefault('limit', 10);
    }
}
```

### Using QueryTypes from PHP code

All QueryTypes are registered in the QueryType registry, which is a Symfony Service injectable as `ezpublish.query_type.registry`:

``` yaml
services:
    App\Controller\LatestContentController:
            autowire: true
            autoconfigure: true
            arguments:
                $registry: '@ezpublish.query_type.registry'
```

Example of PHP code:

```php

<?php

declare(strict_types=1);

namespace App\Controller;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\Core\QueryType\QueryTypeRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class LatestContentController extends AbstractController
{

    /** @var \eZ\Publish\Core\QueryType\QueryTypeRegistry */
    private $registry;
    
    /** @var \eZ\Publish\API\Repository\SearchService */
    private $searchService;
    
    public function __construct(QueryTypeRegistry $registry, SearchService $searchService)
    {
    	$this->searchService = $searchService;
        $this->registry = $registry;    	
    }

    public function showLatestContentAction(string $template, string $contentType): Response
    {
    	$queryType = $this->registry->getQueryType('LatestContent');
    	$query = $queryType->getQuery(['type' => $contentType]);
    	$searchResults = $this->searchService->findContent($query);
    	
    	return $this->render($template, ['results' => $searchResults]);
    }
}

```

### Content query Field Type

The [Content query Field Type](../api/field_type_reference.md#content-query-field-type)
enables you to configure a content query that will use parameters from a Field definition.
The results will be available in a Content item's Field.

Use it by adding a Content query Field Type to your Content Type.

Select a predefined [Query Type](#query-controller) from a list
and provide the parameters that are required by the Query Type, e.g.:

```
parentLocationId: '@=mainLocation.id'
```

Select the Content Type of items you want to return in the **Returned type** dropdown.
To take it into account, your Query Type must filter on the Content Type.
Provide the selected Content Type through the `returnedType` variable:

```
contentType: '@=returnedType'
```

The following variables are available in parameter expressions:

- `returnedType` - the identifier of the Content Type selected in the **Returned type** dropdown
- `content` - the current Content item
- `contentInfo` - the current Content item's ContentInfo
- `mainLocation` - the current Content item's main Location

#### Content query Field Type view

Configure the Content query Field Type's view using the `content_query_field` view type:

``` yaml
content_view:
    content_query_field:
        blog_posts:
            match:
                Identifier\ContentType: blog
                Identifier\FieldDefinition: posts
            template: "blog_posts.html.twig"
```

Query results are provided to the template in the `items` variable:

``` html+twig
{% for item in items %}
    {{ render(controller("ez_content:viewAction", {
        "contentId": item.id,
        "content": item,
        "viewType": itemViewType
    })) }}
{% endfor %}
```

The default view type is `line`, defined under `itemViewType`.
You can change it by passing a different view to `viewType` in the template, e.g.:
`"viewType": "list"`.
