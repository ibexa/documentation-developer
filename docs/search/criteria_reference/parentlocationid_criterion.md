---
description: ParentLocationId Search Criterion
---

# ParentLocationId Criterion

The [`ParentLocationId` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ParentLocationId.html)
searches for content based on the Location ID of its parent.

## Arguments

- `value` - int(s) representing the parent location IDs

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ParentLocationId([54, 58]);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ParentLocationIdCriterion>[81, 82]</ParentLocationIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ParentLocationIdCriterion": [69, 72]
        }
    }
    ```

## Use case

You can use the `ParentLocationId` Search Criterion to list blog posts contained in a blog:

``` php hl_lines="20"
use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService
    ) {}

    public function blogAction(): Response
    {
        $locationId = 12345;
        
        $query = new LocationQuery();
        $query->query = new Criterion\LogicalAnd([
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
            new Criterion\ParentLocationId($locationId),
        ]);
        
        $results = $this->searchService->findLocations($query);
        $posts = [];
        foreach ($results->searchHits as $searchHit) {
            $posts[] = $searchHit;
        }
        
        return $this->render('full/blog.html.twig', [
            'posts' => $posts,
        ]);
    }
}
```

``` html+twig
<p>Posts:</p>
<ul>
    {% for post in posts %}
        <li>{{ post.valueObject.contentInfo.name }}</li>
    {% endfor %}
</ul>
```
