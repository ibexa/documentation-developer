# Content search

[`SearchService`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SearchService.php)
enables you to perform search queries using the PHP API.

The service should be [injected into the constructor of your command or controller.](https://symfony.com/doc/5.0/service_container.html)

!!! tip "SearchService in the Back Office"

    `SearchService` is also used in the Back Office of eZ Platform,
    in components such as Universal Discovery Widget or Sub-items List.

## Performing a search

To search through content you need to create a [`LocationQuery`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/LocationQuery.php)
and provide your search criteria as a series of Criterion objects.

For example, to search for all content of a selected Content Type, use one Criterion,
[`Criterion\ContentTypeIdentifier`](../guide/search/criteria_reference/contenttypeidentifier_criterion.md) (line 14).

The following command takes the Content Type identifier as an argument and lists all results:

``` php hl_lines="14 16"
//...
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class FindContentCommand extends Command
{
    // ...
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contentTypeId = $input->getArgument('contentTypeId');

        $query = new LocationQuery();
        $query->filter = new Criterion\ContentTypeIdentifier($contentTypeId);

        $result = $this->searchService->findContentInfo($query);
        $output->writeln('Found ' . $result->totalCount . ' items');
        foreach ($result->searchHits as $searchHit) {
            $output->writeln($searchHit->valueObject->name);
        }
    }
}
```

[`SearchService::findContentInfo`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SearchService.php#L144) (line 16)
retrieves [`ContentInfo`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) objects of the found Content items.
You can also use [`SearchService::findContent`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SearchService.php#L124) to get full Content objects, together with their Field information.

To query for a single result, for example by providing a Content ID,
use the [`SearchService::findSingle`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SearchService.php#L161) method:

``` php
$criterion = new Criterion\ContentId($contentId);
$result = $this->searchService->findSingle($criterion);
$output->writeln($result->getName());
```

!!! tip

    For full list and details of available Search Criteria, see [Search Criteria reference](../guide/search/search_criteria_reference.md).

!!! note "Search result limit"

    By default search returns up to 25 results. You can change it by setting a different limit to the query:

    ``` php
    $query->limit = 100;
    ```

### Search with `query` and `filter`

You can use two properties of the `Query` object to search for content: `query` and `filter`.

In contrast to `filter`, `query` has an effect of search scoring (relevancy).
It affects default sorting if no Sort Clause is used.
As such, `query` is recommended when the search is based on user input.

The difference between `query` and `filter` is only relevant when using Solr search engine.
With the Legacy search engine both properties will give identical results.

## Searching in a controller

You can use the `SearchService` similarly in a controller, as long as you provide the required parameters.
For example, in the code below `locationId` is provided to list all children of a Location.

``` php hl_lines="20 21 22"
//...
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class CustomController extends Controller
{
    //...
    public function showContentAction($locationId)
    {
        $query = new LocationQuery();
        $query->filter = new Criterion\ParentLocationId($locationId);

        $results = $this->searchService->findContentInfo($query);
        $items = [];
        foreach ($results->searchHits as $searchHit) {
            $items[] = $searchHit;
        }

        return $this->render('custom.html.twig', [
            'items' => $items,
        ]);
    }
}
```

The rendering of results is then relegated to [templates](../guide/templates.md) (lines 20-22).

### Paginating search results

To paginate search results, it is recommended to use the [Pagerfanta library](https://github.com/whiteoctober/Pagerfanta) and [eZ Platform's adapters for it.](https://github.com/ezsystems/ezplatform-kernel/tree/v1.0.0/eZ/Publish/Core/Pagination/Pagerfanta)

``` php
//...
use eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;

class CustomController extends Controller
{
    //...
    public function showContentAction(Request $request, $locationId)
    {
        // formulate a $query

        $pager = new Pagerfanta(
            new ContentSearchAdapter($query, $this->searchService)
        );
        $pager->setMaxPerPage(3);
        $pager->setCurrentPage($request->get('page', 1));

        return $this->render('custom.html.twig', [
                'totalItemCount' => $pager->getNbResults(),
                'pagerItems' => $pager,
            ]
        );
    }
}
```

Pagination can then be rendered for example using the following template:

``` html+twig
{% for item in pagerItems %}
    <h2><a href={{ ez_path(item.valueObject) }}>{{ ez_content_name(item) }}</a></h2>
{% endfor %}

{% if pagerItems.haveToPaginate() %}
    {{ pagerfanta( pagerItems, 'ez') }}
{% endif %}
```

For more information and examples, see [PagerFanta documentation.](https://github.com/whiteoctober/Pagerfanta/blob/master/README.md)

#### Pagerfanta adapters

|Adapter class name|Description|
|------|------|
|[`ContentSearchAdapter`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Pagination/Pagerfanta/ContentSearchAdapter.php)|Makes a search against passed Query and returns [Content](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Content.php) objects.|
|[`ContentSearchHitAdapter`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Pagination/Pagerfanta/ContentSearchHitAdapter.php)|Makes a search against passed Query and returns [SearchHit](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php) objects instead.|
|[`LocationSearchAdapter`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Pagination/Pagerfanta/LocationSearchAdapter.php)|Makes a Location search against passed Query and returns [Location](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Location.php) objects.|
|[`LocationSearchHitAdapter`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Pagination/Pagerfanta/LocationSearchHitAdapter.php)|Makes a Location search against passed Query and  returns [SearchHit](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php) objects instead.|

## Complex search

For more complex searches, you need to combine multiple Criteria.
You can do it using logical operators: `LogicalAnd`, `LogicalOr`, and `LogicalNot`.

``` php hl_lines="6 7 8 11"
$query = new LocationQuery;
$criterion1 = new Criterion\Subtree($this->locationService->loadLocation($locationId)->pathString);
$criterion2 = new Criterion\ContentTypeId($contentTypeId);
$criterion3 = new Criterion\FullText($text);

$query->query = new Criterion\LogicalAnd(
    [$criterion1, $criterion2, $criterion3]
);

$result = $this->searchService->findContentInfo($query);
$output->writeln('Found ' . $result->totalCount . ' items');
foreach ($result->searchHits as $searchHit) {
    $output->writeln($searchHit->valueObject->name);
}
```

This example takes three parameters from a command — `$text`, `$contentTypeId`, and `$locationId`.
It then combines them using `Criterion\LogicalAnd` to search for Content items
that belong to a specific subtree, have the chosen Content Type and contain the provided text (lines 6-8).

This also shows that you can get the total number of search results using the `totalCount` property of search results (line 11).

You can also nest different operators to construct more complex queries.
The example below uses the `LogicalNot` operator to search for all children of the selected parent
that do not belong to the provided Content Type:

``` php
$query->filter = new Criterion\LogicalAnd([
        new Criterion\ParentLocationId($locationId),
        new Criterion\LogicalNot(
            new Criterion\ContentTypeIdentifier($contentTypeId)
        )
    ]
);
```

### Combining independent Criteria

Criteria are independent of one another. This can lead to unexpected behavior, for instance because content can have multiple Locations.

For example, a Content item has two Locations: visible Location A and hidden Location B.
You perform the following query:

``` php
$query->filter = new Criterion\LogicalAnd([
    new LocationId($locationBId),
    new Visibility(Visibility::VISIBLE),
]);
```

The query searches for Location B using the [`LocationId` Criterion](../guide/search/criteria_reference/locationid_criterion.md),
and for visible content using the [`Visibility` Criterion](../guide/search/criteria_reference/visibility_criterion.md).

Even though the Location B is hidden, the query will find the content because both conditions are satisfied:

- the Content item has Location B
- the Content item is visible (it has the visible Location A)


## Sorting results

To sort the results of a query, use one of more [Sort Clauses](../guide/search/sort_clause_reference.md).

For example, to order search results by their publicationg date, from oldest to newest,
and then alphabetically by content name, add the following Sort Clauses to the query:

``` php
$query->sortClauses = [
    new SortClause\DatePublished(LocationQuery::SORT_ASC),
    new SortClause\ContentName(LocationQuery::SORT_DESC),
];
```

!!! tip

    For the full list and details of available Sort Clauses, see [Sort Clause reference](../guide/search/sort_clause_reference.md).

## Faceted search

!!! tip "Checking feature support per search engine"

    Faceted search is available only for the Solr search engine.

    To find out if a given search engine supports any of the advanced search capabilities,
    use the [`eZ\Publish\API\Repository\SearchService::supports`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SearchService.php#L188-L199) method:

    ``` php
    $facetSupport = $this->searchService->supports(SearchService::CAPABILITY_FACETS);
    ```

Faceted search enables you to find the count of search results for each Facet value.

To do this, you need to make use of the query's `$facetBuilders` property:

``` php
$query->facetBuilders[] = new FacetBuilderUserFacetBuilder(
    [
        'name' => 'User',
        'type' => FacetBuilder\UserFacetBuilder::OWNER,
        'minCount' => 2,
        'limit' => 5
    ]
);

$result = $this->searchService->findContentInfo($query);

$output->writeln("Number of results per facet value: ");
foreach ($result->facets[0]->entries as $facetEntry) {
    $output->writeln("* " . $facetEntry);
}
```

See [Search Facet reference](../guide/search/search.md#search-facet-reference) for details of all available Facets.
