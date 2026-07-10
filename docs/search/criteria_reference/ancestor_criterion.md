---
description: Ancestor Search Criterion
---

# Ancestor Criterion

The [`Ancestor` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Ancestor.html) searches for content that is an ancestor of the provided location, including this location.

## Arguments

- `value` - array of location pathStrings

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
/** @var LocationService $locationService */
$query->query = new Criterion\Ancestor([$locationService->loadLocation(62)->pathString]);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <AncestorCriterion>/81/82/</AncestorCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "AncestorCriterion": "/81/82/"
        }
    }
    ```

## Use case

You can use the Ancestor Search Criterion to create a list of breadcrumbs leading to the Location:

``` php hl_lines="20"
use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly SearchService $searchService
    ) {}

    public function breadcrumbsAction(): Response
    {
        $locationId = 12345;
        
        $query = new LocationQuery();
        $query->query = new Criterion\Ancestor([$this->locationService->loadLocation($locationId)->pathString]);
        
        /** @var SearchService $searchService */
        $results = $this->searchService->findLocations($query);
        $breadcrumbs = [];
        foreach ($results->searchHits as $searchHit) {
            $breadcrumbs[] = $searchHit;
        }
        
        return $this->render('parts/breadcrumbs.html.twig', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
```

``` html+twig
{% for breadcrumb in breadcrumbs %}
    {% if not loop.first %} -> {% endif %}
    {% if not loop.last %}
        <a href="{{ ibexa_path( breadcrumb.valueObject ) }}">{{ breadcrumb.valueObject.contentInfo.name }}</a>
    {% else %}
        {{ breadcrumb.valueObject.contentInfo.name }}
    {% endif %}
{% endfor %}
```
