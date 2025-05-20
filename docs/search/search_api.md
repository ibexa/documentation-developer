---
description: You can search for content, locations and products by using the PHP API. Fine-tune the search with Search Criteria, Sort Clauses and Aggregations.
---

# Search API

You can search for content with the PHP API in two ways.

To do this, you can use the [`SearchService`](#searchservice) or [Repository filtering](#repository-filtering).

## SearchService

[`SearchService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html) enables you to perform search queries by using the PHP API.

The service should be [injected into the constructor of your command or controller](php_api.md#service-container).

!!! tip "SearchService in the back office"

    `SearchService` is also used in the back office of [[= product_name =]], in components such as Universal Discovery Widget or Sub-items List.

### Performing a search

To search through content you need to create a [`LocationQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-LocationQuery.html) and provide your Search Criteria as a series of Criterion objects.

For example, to search for all content of a selected content type, use one Criterion, [`Criterion\ContentTypeIdentifier`](contenttypeidentifier_criterion.md) (line 14).

The following command takes the content type identifier as an argument and lists all results:

``` php hl_lines="14 16"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindContentCommand.php', 4, 7) =]]// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindContentCommand.php', 12, 14) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindContentCommand.php', 31, 47) =]]
```

[`SearchService::findContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html#method_findContentInfo) (line 16)
retrieves [`ContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Persistence-Content-ContentInfo.html) objects of the found content items.
You can also use [`SearchService::findContent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html#method_findContent) to get full Content objects, together with their field information.

To query for a single result, for example by providing a Content ID, use the [`SearchService::findSingle`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html#method_findSingle) method:

``` php
$criterion = new Criterion\ContentId($contentId);
$result = $this->searchService->findSingle($criterion);
$output->writeln($result->getName());
```

!!! tip

    For full list and details of available Search Criteria, see [Search Criteria reference](search_criteria_reference.md).

!!! note "Search result limit"

    By default search returns up to 25 results.
    You can change it by setting a different limit to the query:

    ``` php
    $query->limit = 100;
    ```

#### Search with `query` and `filter`

You can use two properties of the `Query` object to search for content: `query` and `filter`.

In contrast to `filter`, `query` has an effect of search scoring (relevancy).
It affects default sorting if no Sort Clause is used.
As such, `query` is recommended when the search is based on user input.

The difference between `query` and `filter` is only relevant when using Solr or Elasticsearch search engine.
With the Legacy search engine both properties give identical results.

#### Processing large result sets

To process a large result set, use [`Ibexa\Contracts\Core\Repository\Iterator\BatchIterator`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Iterator-BatchIterator.html).
`BatchIterator` divides the results of search or filtering into smaller batches.
This enables iterating over results that are too large to handle due to memory constraints.

`BatchIterator` takes one of the available adapters ([`\Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-iterator-batchiteratoradapter.html)) and optional batch size. For example:

``` php
$query = new LocationQuery;

$iterator = new BatchIterator(new BatchIteratorAdapter\LocationSearchAdapter($this->searchService, $query));

foreach ($iterator as $result) {
    $output->writeln($result->valueObject->getContentInfo()->name);
}
```

You can also define the batch size by setting `$iterator->setBatchSize()`.

The following BatchIterator adapters are available, for both `query` and `filter` searches:

| Adapter                                                                                                                                                                            | Method                                                                                                                                                                                                                                             |
|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [`ContentFilteringAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Iterator-BatchIteratorAdapter-ContentFilteringAdapter.html)                | [`Ibexa\Contracts\Core\Repository\ContentService::find`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_find)                                                                              |
| [`ContentInfoSearchAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Iterator-BatchIteratorAdapter-ContentInfoSearchAdapter.html)              | [`Ibexa\Contracts\Core\Repository\SearchService::findContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html#method_findContentInfo)                                                          |
| [`ContentSearchAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Iterator-BatchIteratorAdapter-ContentSearchAdapter.html)                      | [`Ibexa\Contracts\Core\Repository\SearchService::findContent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html#method_findContent)                                                                  |
| [`LocationFilteringAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Iterator-BatchIteratorAdapter-LocationFilteringAdapter.html)              | [`Ibexa\Contracts\Core\Repository\LocationService::find`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_find)                                                                            |
| [`LocationSearchAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Iterator-BatchIteratorAdapter-LocationSearchAdapter.html)                    | [`Ibexa\Contracts\Core\Repository\SearchService::findLocations`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html#method_findLocations)                                                              |
| [`AttributeDefinitionFetchAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Iterator-BatchIteratorAdapter-AttributeDefinitionFetchAdapter.html) | [`Ibexa\Contracts\ProductCatalog\AttributeDefinitionServiceInterface::findAttributesDefinitions`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeDefinitionServiceInterface.html#method_findAttributesDefinitions) |
| [`AttributeGroupFetchAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Iterator-BatchIteratorAdapter-AttributeGroupFetchAdapter.html)           | [`Ibexa\Contracts\ProductCatalog\AttributeGroupServiceInterface::findAttributeGroups`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeGroupServiceInterface.html#method_findAttributeGroups)                  |
| [`CurrencyFetchAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Iterator-BatchIteratorAdapter-CurrencyFetchAdapter.html)                       | [`Ibexa\Contracts\ProductCatalog\CurrencyServiceInterface::findCurrencies`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-CurrencyServiceInterface.html#method_findCurrencies)                                        |
| [`ProductTypeListAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Iterator-BatchIteratorAdapter-ProductTypeListAdapter.html)                   | [`Ibexa\Contracts\ProductCatalog\ProductTypeServiceInterface::findProductTypes`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductTypeServiceInterface.html#method_findProductTypes)                              |

## Repository filtering

You can use the `ContentService::find(Filter)` method to find content items or `LocationService::find(Filter)` to find locations by using a defined Filter.

`ContentService::find` returns an iterable [`ContentList`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentList.html) while `LocationService::find` returns an iterable [`LocationList`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-LocationList.html).

Filtering differs from search.
It doesn't use the `SearchService` and isn't based on indexed data.

[`Filter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Filter-Filter.html) enables you to configure a query by using chained methods to select criteria, sorting, limit, and offset.

For example, the following command lists all content items under the specified parent location and sorts them by name in descending order:

``` php hl_lines="13-16"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterCommand.php', 4, 9) =]]
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterCommand.php', 32, 52) =]]
```

The same Filter can be applied to find locations instead of content items, for example:

``` php hl_lines="17"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterLocationCommand.php', 4, 9) =]]// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FilterLocationCommand.php', 32, 52) =]]
```

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

The following example filters for Folder content items under the parent location 2, sorts them by publication date and returns 10 results, starting from the third one:

``` php
$filter = new Filter();
$filter
    ->withCriterion(new Criterion\ContentTypeIdentifier('folder'))
    ->andWithCriterion(new Criterion\ParentLocationId(2))
    ->withSortClause(new SortClause\DatePublished(Query::SORT_ASC))
    ->sliceBy(10, 2);
```

!!! note "Search Criteria and Sort Clause availability"

    Not all Search Criteria and Sort Clauses are available for use in repository filtering.

    Only Criteria implementing [`FilteringCriterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Filter-FilteringCriterion.html) and Sort Clauses implementing [`FilteringSortClause`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Filter-FilteringSortClause.html) are supported.

    See [Search Criteria](search_criteria_reference.md) and [Sort Clause reference](sort_clause_reference.md) for details.

!!! tip

    It's recommended to use an IDE that can recognize type hints when working with Repository Filtering.
    If you try to use an unsupported Criterion or Sort Clause, the IDE indicates an issue.

## Searching in a controller

You can use the `SearchService` or repository filtering in a controller, as long as you provide the required parameters.
For example, in the code below, `locationId` is provided to list all children of a location by using the `SearchService`.

``` php hl_lines="22-24"
// ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomController.php', 4, 12) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomController.php', 19, 35) =]]
```

The rendering of results is then relegated to [templates](templates.md) (lines 22-24).

When using Repository filtering, provide the results of `ContentService::find()` as parameters to the view:

``` php hl_lines="19"
// ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomFilterController.php', 4, 12) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Controller/CustomFilterController.php', 19, 34) =]]
```

### Paginating search results

To paginate search or filtering results, it's recommended to use the [Pagerfanta library](https://github.com/BabDev/Pagerfanta) and [[[= product_name =]]'s adapters for it.](https://github.com/ibexa/core/blob/4.6/src/lib/Pagination/Pagerfanta/Pagerfanta.php)

``` php
// ...
[[= include_file('code_samples/api/public_php_api/src/Controller/PaginationController.php', 8, 15) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Controller/PaginationController.php', 22, 32) =]]
[[= include_file('code_samples/api/public_php_api/src/Controller/PaginationController.php', 33, 43) =]]
```

Pagination can then be rendered for example using the following template:

``` html+twig
[[= include_file('code_samples/api/public_php_api/templates/themes/standard/full/custom_pagination.html.twig') =]]
```

For more information and examples, see [PagerFanta documentation](https://www.babdev.com/open-source/packages/pagerfanta/docs/2.x/usage).

#### Pagerfanta adapters

| Adapter class name                                                                                                                                   | Description                                                                                                                                                                                                                                    |
|------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [`ContentSearchAdapter`](https://github.com/ibexa/core/blob/4.6/src/lib/Pagination/Pagerfanta/ContentSearchAdapter.php)                             | Makes a search against passed Query and returns [`Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) objects.                                                                  |
| [`ContentSearchHitAdapter`](https://github.com/ibexa/core/blob/4.6/src/lib/Pagination/Pagerfanta/ContentSearchHitAdapter.php)                       | Makes a search against passed Query and returns [`SearchHit`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Search-SearchHit.html) objects instead.                                               |
| [`LocationSearchAdapter`](https://github.com/ibexa/core/blob/4.6/src/lib/Pagination/Pagerfanta/LocationSearchAdapter.php)                           | Makes a location search against passed Query and returns [`Location`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Location.html) objects.                                                       |
| [`LocationSearchHitAdapter`](https://github.com/ibexa/core/blob/4.6/src/lib/Pagination/Pagerfanta/LocationSearchHitAdapter.php)                     | Makes a location search against passed Query and  returns [`SearchHit`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Search-SearchHit.html) objects instead.                                     |
| [`ContentFilteringAdapter`](https://github.com/ibexa/core/blob/4.6/src/lib/Pagination/Pagerfanta/ContentFilteringAdapter.php)                       | Applies a Content filter and returns a [`ContentList`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentList.html) object.                                                                    |
| [`LocationFilteringAdapter`](https://github.com/ibexa/core/blob/4.6/src/lib/Pagination/Pagerfanta/LocationFilteringAdapter.php)                     | Applies a location filter and returns a [`LocationList`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-LocationList.html) object.                                                                 |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\AttributeDefinitionListAdapter` | Makes a search for product attributes and returns an [`AttributeDefinitionListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-AttributeDefinition-AttributeDefinitionListInterface.html) object. |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\AttributeGroupListAdapter` | Makes a search for product attribute groups and returns an [`AttributeGroupListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-AttributeGroup-AttributeGroupListInterface.html) object.          |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\CurrencyListAdapter` | Makes a search for currencies and returns a [`CurrencyListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Currency-CurrencyListInterface.html) object.                                           |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\CustomPricesAdapter` | Makes a search for custom prices and returns a `Ibexa\Bundle\ProductCatalog\UI\CustomPrice` object. |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\CustomerGroupListAdapter` | Makes a search for customer groups and returns a [`CustomerGroupListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-CustomerGroup-CustomerGroupListInterface.html) object.                       |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\ProductListAdapter` | Makes a search for products and returns a [`ProductListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductListInterface.html) object.                                                |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\ProductTypeListAdapter | Makes a search for product types and returns a [`ProductTypeListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductType-ProductTypeListInterface.html) object.                               |
| `Ibexa\ProductCatalog\Pagerfanta\Adapter\RegionListAdapter | Makes a search for regions and returns a [`RegionListInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Region-RegionListInterface.html) object.                                                    |

## Complex search

For more complex searches, you need to combine multiple Criteria.
You can do it using logical operators: `LogicalAnd`, `LogicalOr`, and `LogicalNot`.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 43, 49) =]][[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 53, 54) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 60, 65) =]]
```

This example takes three parameters from a command — `$text`, `$contentTypeId`, and `$locationId`.
It then combines them using `Criterion\LogicalAnd` to search for content items
that belong to a specific subtree, have the chosen content type and contain the provided text (lines 3-6).

This also shows that you can get the total number of search results using the `totalCount` property of search results (line 9).

You can also nest different operators to construct more complex queries.
The example below uses the `LogicalNot` operator to search for all content containing a given phrase
that doesn't belong to the provided Section:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 45, 46) =]][[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 48, 53) =]]
```

### Combining independent Criteria

Criteria are independent of one another.
This can lead to unexpected behavior, for instance because content can have multiple locations.

For example, a content item has two locations: visible location A and hidden location B.
You perform the following query:

``` php
$query->filter = new Criterion\LogicalAnd([
    new LocationId($locationBId),
    new Visibility(Visibility::VISIBLE),
]);
```

The query searches for location B by using the [`LocationId` Criterion](locationid_criterion.md), and for visible content by using the [`Visibility` Criterion](visibility_criterion.md).

Even though the location B is hidden, the query finds the content because both conditions are satisfied:

- the content item has location B
- the content item is visible (it has the visible location A)


## Sorting results

To sort the results of a query, use one of more [Sort Clauses](sort_clause_reference.md).

For example, to order search results by their publicationg date, from oldest to newest, and then alphabetically by content name, add the following Sort Clauses to the query:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindComplexCommand.php', 55, 59) =]]
```

!!! tip

    For the full list and details of available Sort Clauses, see [Sort Clause reference](sort_clause_reference.md).

## Searching in trash

In the user interface, on the **Trash** screen, you can search for content items, and then sort the results based on different criteria.
To search the trash with the API, use the `TrashService::findInTrash` method to submit a query for content items that are held in trash.
Searching in trash supports a limited set of Criteria and Sort Clauses.
For a list of supported Criteria and Sort Clauses, see [Search in trash reference](search_in_trash_reference.md).

!!! note

    Searching through the trashed content items operates directly on the database, therefore you cannot use external search engines, such as Solr or Elasticsearch, and it's impossible to reindex the data.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindInTrashCommand.php', 34, 41) =]]
```

!!! caution

    Make sure that you set the Criterion on the `filter` property.
    It's impossible to use the `query` property, because the search in trash operation filters the database instead of querying.

## Aggregation

!!! caution "Feature support"

    Aggregation is only available in the Solr and Elasticsearch search engines.

With aggregations you can find the count of search results or other result information for each Aggregation type.

To do this, you use of the query's `$aggregations` property:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 34, 39) =]]
```

The name of the aggregation must be unique in the given query.

Access the results by using the `get()` method of the aggregation:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 43, 44) =]]
```

Aggregation results contain the name of the result and the count of found items:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 46, 49) =]]
```

With field aggregations you can group search results according to the value of a specific field.
In this case the aggregation takes the content type identifier and the field identifier as parameters.

The following example creates an aggregation named `selection` that groups results according to the value of the `topic` field in the `article` content type:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 39, 40) =]]
```

With term aggregation you can define additional limits to the results.
The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FindWithAggregationCommand.php', 34, 37) =]]
```

To use a range aggregation, you must provide a `ranges` array containing a set of `Range` objects that define the borders of the specific range sets.

``` php
$query->aggregations[] = new IntegerRangeAggregation('range', 'person', 'age',
[
    new Query\Aggregation\Range(1,30),
    new Query\Aggregation\Range(30,60),
    new Query\Aggregation\Range(60,null),
]);
```

!!! note

    The beginning of the range is included and the end is excluded, so a range between 1 and 30 includes value `1`, but not `30`.

    `null` means that a range doesn't have an end.
    In the example all values above (and including) 60 are included in the last range.

See [Agrregation reference](aggregation_reference.md) for details of all available aggregations.
