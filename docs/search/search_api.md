---
description: You can search for content, Locations and products by using the PHP API. Fine-tune the search with Search Criteria, Sort Clauses and Aggregations.
---

# Search API

You can search for content with the PHP API in two ways.

To do this, you can use the [`SearchService`](#searchservice) or [Repository filtering](#repository-filtering).

## SearchService

[`SearchService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SearchService.php)
enables you to perform search queries using the PHP API.

The service should be [injected into the constructor of your command or controller](php_api.md#service-container).

!!! tip "SearchService in the Back Office"

    `SearchService` is also used in the Back Office of [[= product_name =]],
    in components such as Universal Discovery Widget or Sub-items List.

### Performing a search

To search through content you need to create a [`LocationQuery`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/LocationQuery.php)
and provide your search criteria as a series of Criterion objects.

For example, to search for all content of a selected Content Type, use one Criterion,
[`Criterion\ContentTypeIdentifier`](contenttypeidentifier_criterion.md) (line 14).

The following command takes the Content Type identifier as an argument and lists all results:

``` php hl_lines="14 16"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindContentCommand.php', 8, 14) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindContentCommand.php', 31, 47) =]]
```

[`SearchService::findContentInfo`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SearchService.php#L144) (line 16)
retrieves [`ContentInfo`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php) objects of the found Content items.
You can also use [`SearchService::findContent`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SearchService.php#L124) to get full Content objects, together with their Field information.

To query for a single result, for example by providing a Content ID,
use the [`SearchService::findSingle`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SearchService.php#L161) method:

``` php
$criterion = new Criterion\ContentId($contentId);
$result = $this->searchService->findSingle($criterion);
$output->writeln($result->getName());
```

!!! tip

    For full list and details of available Search Criteria, see [Search Criteria reference](search_criteria_reference.md).

!!! note "Search result limit"

    By default search returns up to 25 results. You can change it by setting a different limit to the query:

    ``` php
    $query->limit = 100;
    ```

#### Search with `query` and `filter`

You can use two properties of the `Query` object to search for content: `query` and `filter`.

In contrast to `filter`, `query` has an effect of search scoring (relevancy).
It affects default sorting if no Sort Clause is used.
As such, `query` is recommended when the search is based on user input.

The difference between `query` and `filter` is only relevant when using Solr or Elasticsearch search engine.
With the Legacy search engine both properties will give identical results.

#### Processing large result sets

To process a large result set, use `Ibexa\Contracts\Core\Repository\Iterator\BatchIterator`.
`BatchIterator` divides the results of search or filtering into smaller batches.
This enables iterating over results that are too large to handle due to memory constraints.

`BatchIterator` takes one of the available adapters (`\Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter` ) and optional batch size. For example: 

``` php
$query = new LocationQuery;

$iterator = new BatchIterator(new BatchIteratorAdapter\LocationSearchAdapter($this->searchService, $query));

foreach ($iterator as $result) {
    $output->writeln($result->valueObject->getContentInfo()->name);
}
```

You can also define the batch size by setting `$iterator->setBatchSize()`.

The following BatchIterator adapters are available, for both `query` and `filter` searches:

| Adapter                    | Method                                                      |
|----------------------------|-------------------------------------------------------------|
| `ContentFilteringAdapter`  | `\Ibexa\Contracts\Core\Repository\ContentService::find`           |
| `ContentInfoSearchAdapter` | `\Ibexa\Contracts\Core\Repository\SearchService::findContentInfo` |
| `ContentSearchAdapter`     | `\Ibexa\Contracts\Core\Repository\SearchService::findContent`     |
| `LocationFilteringAdapter` | `\Ibexa\Contracts\Core\Repository\LocationService::find`          |
| `LocationSearchAdapter`    | `\Ibexa\Contracts\Core\Repository\SearchService::findLocations`   |
| `AttributeDefinitionFetchAdapter` | `Ibexa\Contracts\ProductCatalog\AttributeDefinitionServiceInterface::findAttributesDefinitions` |
| `AttributeGroupFetchAdapter` | `Ibexa\Contracts\ProductCatalog\AttributeGroupServiceInterface::findAttributeGroups` |
| `CurrencyFetchAdapter` | `Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface::findCurrencies` |
| `ProductTypeListAdapter` | `Ibexa\Contracts\ProductCatalog\ProductTypeServiceInterface::findProductTypes` |

## Repository filtering

You can use the `ContentService::find(Filter)` method to find Content items or
`LocationService::find(Filter)` to find Locations using a defined Filter.

`ContentService::find` returns an iterable [`ContentList`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentList.php)
while `LocationService::find` returns an iterable [`LocationList`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/LocationList).

Filtering differs from search. It does not use the `SearchService` and is not based on indexed data.

[`Filter`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Filter/Filter.php) enables you to configure a query using chained methods to select criteria, sorting, limit and offset.

For example, the following command lists all Content items under the specified parent Location
and sorts them by name in descending order:

``` php hl_lines="16-19"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterCommand.php', 8, 16) =]]
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterCommand.php', 32, 52) =]]
```

The same Filter can be applied to find Locations instead of Content items, for example:

``` php hl_lines="20"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterLocationCommand.php', 8, 16) =]]// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterLocationCommand.php', 32, 52) =]]
```

Notice that the total number of items is retrieved differently for `ContentList` and `LocationList`.

!!! caution

    The total count is the total number of matched items, regardless of pagination settings.

!!! tip "Repository filtering is SiteAccess-aware"

    Repository filtering is SiteAccess-aware, which means you can skip the second argument of the `find` methods.
    In that case languages from a current context are injected and added as a LanguageCode Criterion filter.

You can use the following methods of the Filter:

- `withCriterion` - add the first Criterion to the Filter
- `andWithCriterion` - add another Criterion to the Filter using a LogicalAnd operation. If this is the first Criterion, this method works like `withCriterion`
- `orWithCriterion` - add a Criterion using a LogicalOr operation. If this is the first Criterion, this method works like `withCriterion`
- `withSortClause` - add a Sort Clause to the Filter
- `sliceBy` - set limit and offset for pagination
- `reset` - remove all Criteria, Sort Clauses, and pagination settings

The following example filters for Folder Content items under the parent Location 2,
sorts them by publication date and returns 10 results, starting from the third one:

``` php
$filter = new Filter();
$filter
    ->withCriterion(new Criterion\ContentTypeIdentifier('folder'))
    ->andWithCriterion(new Criterion\ParentLocationId(2))
    ->withSortClause(new SortClause\DatePublished(Query::SORT_ASC))
    ->sliceBy(10, 2);
```

!!! note "Search Criteria and Sort Clause availability"

    Not all Search Criteria and Sort Clauses are available for use in Repository filtering.

    Only Criteria implementing [`FilteringCriterion`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Filter/FilteringCriterion.php)
    and Sort Clauses implementing [`FilteringSortClause`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Filter/FilteringSortClause.php)
    are supported.

    See [Search Criteria](search_criteria_reference.md)
    and [Sort Clause reference](sort_clause_reference.md) for details.

!!! tip

    It is recommended to use an IDE that can recognize type hints when working with Repository Filtering.
    If you try to use an unsupported Criterion or Sort Clause, the IDE will indicate an issue.

## Searching in a controller

You can use the `SearchService` or Repository filtering in a controller, as long as you provide the required parameters.
For example, in the code below, `locationId` is provided to list all children of a Location by using the `SearchService`.

``` php hl_lines="21-23"
// ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomController.php', 4, 11) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomController.php', 18, 34) =]]
```

The rendering of results is then relegated to [templates](templates.md) (lines 20-22).

When using Repository filtering, provide the results of `ContentService::find()` as parameters to the view:

``` php hl_lines="19"
// ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomFilterController.php', 4, 12) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomFilterController.php', 19, 34) =]]
```

### Paginating search results

To paginate search or filtering results, it is recommended to use the [Pagerfanta library](https://github.com/whiteoctober/Pagerfanta) and [[[= product_name =]]'s adapters for it.](https://github.com/ibexa/core/blob/main/src/lib/Pagination/Pagerfanta/Pagerfanta.php)

``` php
// ...
[[= include_file('code_samples/api/public_php_api/src/Controller/PaginationController.php', 8, 14) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Controller/PaginationController.php', 21, 31) =]]
[[= include_file('code_samples/api/public_php_api/src/Controller/PaginationController.php', 35, 42) =]]
```

Pagination can then be rendered for example using the following template:

``` html+twig
[[= include_file('code_samples/api/public_php_api/templates/custom_pagination.html.twig') =]]
```

For more information and examples, see [PagerFanta documentation.](https://github.com/whiteoctober/Pagerfanta/blob/master/README.md)

#### Additional search result data

You can access the following additional search result data from PagerFanta:

- Aggregation results
- Max. score
- Computation time
- Timeout flag

``` php
[[= include_file('code_samples/api/public_php_api/src/Controller/PaginationController.php', 32, 34) =]]
```

``` html+twig
<p>Max score: {{ pagerItems.maxScore }}</p>
<p>Time: {{ pagerItems.time }}</p>
```

#### Pagerfanta adapters

|Adapter class name|Description|
|------|------|
|[`ContentSearchAdapter`](https://github.com/ibexa/core/blob/main/src/lib/Pagination/Pagerfanta/ContentSearchAdapter.php)|Makes a search against passed Query and returns [Content](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Content.php) objects.|
|[`ContentSearchHitAdapter`](https://github.com/ibexa/core/blob/main/src/lib/Pagination/Pagerfanta/ContentSearchHitAdapter.php)|Makes a search against passed Query and returns [SearchHit](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Search/SearchHit.php) objects instead.|
|[`LocationSearchAdapter`](https://github.com/ibexa/core/blob/main/src/lib/Pagination/Pagerfanta/LocationSearchAdapter.php)|Makes a Location search against passed Query and returns [Location](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Location.php) objects.|
|[`LocationSearchHitAdapter`](https://github.com/ibexa/core/blob/main/src/lib/Pagination/Pagerfanta/LocationSearchHitAdapter.php)|Makes a Location search against passed Query and  returns [SearchHit](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Search/SearchHit.php) objects instead.|
|[`ContentFilteringAdapter`](https://github.com/ibexa/core/blob/main/src/lib/Pagination/Pagerfanta/ContentFilteringAdapter.php)|Applies a Content filter and returns a `ContentList` object.|
|[`LocationFilteringAdapter`](https://github.com/ibexa/core/blob/main/src/lib/Pagination/Pagerfanta/LocationFilteringAdapter.php)|Applies a Location filter and returns a `LocationList` object.|
|`AttributeDefinitionListAdapter`| Makes a search for product attributes and returns an `AttributeDefinitionListInterface` object. |
|`AttributeGroupListAdapter`| Makes a search for product attribute groups and returns an `AttributeGroupListInterface` object. |
|`CurrencyListAdapter`| Makes a search for currencies and returns a `CurrencyListInterface` object.
|`CustomPricesAdapter`| Makes a search for custom prices and returns a `CustomPrice` object. |
|`CustomerGroupListAdapter`| Makes a search for customer groups and returns a `CustomerGroupListInterface` object. |
|`ProductListAdapter`| Makes a search for products and returns a `ProductListInterface` object. |
|`ProductTypeListAdapter`| Makes a search for product types and returns a `ProductTypeListInterface` object. |
|`RegionListAdapter`| Makes a search for regions and returns a `RegionListInterface` object. |

## Complex search

For more complex searches, you need to combine multiple Criteria.
You can do it using logical operators: `LogicalAnd`, `LogicalOr`, and `LogicalNot`.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 43, 49) =]][[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 52, 53) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 59, 64) =]]
```

This example takes three parameters from a command — `$text`, `$contentTypeId`, and `$locationId`.
It then combines them using `Criterion\LogicalAnd` to search for Content items
that belong to a specific subtree, have the chosen Content Type and contain the provided text (lines 6-8).

This also shows that you can get the total number of search results using the `totalCount` property of search results (line 11).

You can also nest different operators to construct more complex queries.
The example below uses the `LogicalNot` operator to search for all content containing a given phrase
that does not belong to the provided Section:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 45, 46) =]][[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 48, 53) =]]
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

The query searches for Location B using the [`LocationId` Criterion](locationid_criterion.md),
and for visible content using the [`Visibility` Criterion](visibility_criterion.md).

Even though the Location B is hidden, the query will find the content because both conditions are satisfied:

- the Content item has Location B
- the Content item is visible (it has the visible Location A)


## Sorting results

To sort the results of a query, use one of more [Sort Clauses](sort_clause_reference.md).

For example, to order search results by their publicationg date, from oldest to newest,
and then alphabetically by content name, add the following Sort Clauses to the query:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 54, 58) =]]
```

!!! tip

    For the full list and details of available Sort Clauses, see [Sort Clause reference](sort_clause_reference.md).

## Searching in trash

In the user interface, on the Trash screen, you can search for Content items, and then sort the results based on different criteria.
To search the trash with the API, use the `TrashService::findInTrash` method to submit a query for Content items that are held in trash.
Searching in trash supports a limited set of Criteria and Sort Clauses.
For a list of supported Criteria and Sort Clauses, see [Search in trash reference](search_in_trash_reference.md).

!!! note

    Searching through the trashed Content items operates directly on the database, therefore you cannot use external search engines, such as Solr or Elasticsearch, and it is impossible to reindex the data.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindInTrashCommand.php', 34, 41) =]]
```

!!! caution

    Make sure that you set the Criterion on the `filter` property.
    It is impossible to use the `query` property, because the search in trash operation filters the database instead of querying.

## Aggregation

!!! caution "Feature support"

    Aggregation is only available in the Solr and Elasticsearch search engines.

With aggregations you can find the count of search results or other result information for each Aggregation type.

To do this, you use of the query's `$aggregations` property:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 34, 35) =]]
```

The name of the aggregation must be unique in the given query.

Access the results by using the `get()` method of the aggregation:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 39, 40) =]]
```

Aggregation results contain the name of the result and the count of found items:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 45, 48) =]]
```

With field aggregations you can group search results according to the value of a specific Field.
In this case the aggregation takes the Content Type identifier and the Field identifier as parameters.

The following example creates an aggregation named `selection` that groups results
according to the value of the `topic` Field in the `article` Content Type:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 35, 36) =]]
```

With term aggregation you can define additional limits to the results.
The following example limits the number of terms returned to 5
and only considers terms that have 10 or more results:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 42, 44) =]]
```

To use a range aggregation, you must provide a `ranges` array containing a set of `Range` objects
that define the borders of the specific range sets.

``` php
$query->aggregations[] = new IntegerRangeAggregation('range', 'person', 'age',
[
    new Query\Aggregation\Range(1,30),
    new Query\Aggregation\Range(30,60),
    new Query\Aggregation\Range(60,null),
]);
```

!!! note

    The beginning of the range is included and the end is excluded,
    so a range between 1 and 30 will include value `1`, but not `30`.
    
    `null` means that a range does not have an end.
    In the example all values above (and including) 60 are included in the last range.

See [Agrregation reference](aggregation_reference.md) for details of all available aggregations.
