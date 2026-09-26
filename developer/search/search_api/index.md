# Search API

You can search for content, locations and products by using the PHP API. Fine-tune the search with Search Criteria, Sort Clauses and Aggregations.

You can search for content with the PHP API in two ways.

To do this, you can use the [`SearchService`](#searchservice) or [Repository filtering](#repository-filtering).

## SearchService

[`Ibexa\Contracts\Core\Repository\SearchService`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php) enables you to perform search queries by using the PHP API.

The service should be [injected into the constructor of your command or controller](../../api/php_api/php_api/index.md#service-container).

> **Tip: SearchService in the back office**
>
> `SearchService` is also used in the back office of Ibexa DXP, in components such as Universal Discovery Widget or Sub-items List.

### Perform search

To search through content you need to create a [`Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/LocationQuery.php) and provide your Search Criteria as a series of Criterion objects.

For example, to search for all content of a selected content type, use one Criterion, [`Criterion\ContentTypeIdentifier`](../criteria_reference/contenttypeidentifier_criterion/index.md) (line 14).

The following command takes the content type identifier as an argument and lists all results:

```php
// ...
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
// ...
class FindContentCommand extends Command
{
    // ...
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentTypeIdentifier = $input->getArgument('contentTypeIdentifier');

        $query = new LocationQuery();
        $query->filter = new Criterion\ContentTypeIdentifier($contentTypeIdentifier);

        $result = $this->searchService->findContentInfo($query);

        $output->writeln('Found ' . $result->totalCount . ' items');
        foreach ($result->searchHits as $searchHit) {
            $output->writeln($searchHit->valueObject->name);
        }

        return self::SUCCESS;
    }
}
```

[`SearchService::findContentInfo`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php) (line 16) retrieves [`Ibexa\Contracts\Core\Persistence\Content\ContentInfo`](../../../../../ibexa/core/src/contracts/Persistence/Content/ContentInfo.php) objects of the found content items. You can also use [`SearchService::findContent`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php) to get full Content objects, together with their field information.

To query for a single result, for example by providing a Content ID, use the [`SearchService::findSingle`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php) method:

```php
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\Console\Output\OutputInterface;

$contentId = 12345;
$criterion = new Criterion\ContentId($contentId);

/** @var SearchService $searchService */
$result = $searchService->findSingle($criterion);

/** @var OutputInterface $output */
$output->writeln($result->getName() ?? '');
```

> **Tip: Tip**
>
> For full list and details of available Search Criteria, see [Search Criteria reference](../criteria_reference/search_criteria_reference/index.md).

> **Note: Search result limit**
>
> By default search returns up to 25 results. You can change it by setting a different limit to the query:
>
> ```php
> use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
>
> $query = new LocationQuery();
> $query->limit = 100;
> ```

#### Disable result count

By default, a search query also counts all matching results. If you don't need the total count, set `performCount` to `false` on [`Ibexa\Contracts\Core\Repository\Values\Content\Query`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query.php) or [`Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/LocationQuery.php) to improve performance, especially for large result sets.

```php
// For location searches
$locationQuery = new LocationQuery();
$locationQuery->performCount = false;

// For content searches
$contentQuery = new Query();
$contentQuery->performCount = false;
```

When `performCount` is set to `false`, `$result->totalCount` is `null`.

#### Search with `query` and `filter`

You can use two properties of the `Query` object to search for content: `query` and `filter`.

In contrast to `filter`, `query` has an effect of search scoring (relevancy). It affects default sorting if no Sort Clause is used. As such, `query` is recommended when the search is based on user input.

The difference between `query` and `filter` is only relevant when using Solr or Elasticsearch search engine. With the Legacy search engine both properties give identical results.

#### Process large result sets

To process a large result set, use [`Ibexa\Contracts\Core\Repository\Iterator\BatchIterator`](../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIterator.php). `BatchIterator` divides the results of search or filtering into smaller batches. This enables iterating over results that are too large to handle due to memory constraints.

`BatchIterator` takes one of the available adapters ([`\Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-iterator-batchiteratoradapter.html)) and optional batch size. For example:

```php
use Ibexa\Contracts\Core\Repository\Iterator\BatchIterator;
use Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Symfony\Component\Console\Output\OutputInterface;

$query = new LocationQuery();

/** @var SearchService $searchService */
$iterator = new BatchIterator(new BatchIteratorAdapter\LocationSearchAdapter($searchService, $query));

foreach ($iterator as $result) {
    /** @var OutputInterface $output */
    $output->writeln($result->valueObject->getContentInfo()->name);
}
```

You can also define the batch size by setting `$iterator->setBatchSize()`.

The following BatchIterator adapters are available, for both `query` and `filter` searches, here with the method they replace:

| Adapter                                                                                                                                                                                                  | Regular method                                                                                                                                                                                                                                   |
| -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| [`Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\ContentFilteringAdapter`](../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIteratorAdapter/ContentFilteringAdapter.php)                | [`ContentService::find()`](../../../../../ibexa/core/src/contracts/Repository/ContentService.php)                                                                                    |
| [`Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\ContentInfoSearchAdapter`](../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIteratorAdapter/ContentInfoSearchAdapter.php)              | [`SearchService::findContentInfo()`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php)                                                                |
| [`Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\ContentSearchAdapter`](../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIteratorAdapter/ContentSearchAdapter.php)                      | [`SearchService::findContent()`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php)                                                                        |
| [`Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\RelationListIteratorAdapter`](../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIteratorAdapter/RelationListIteratorAdapter.php)        | [`ContentService::loadRelationList()`](../../../../../ibexa/core/src/contracts/Repository/ContentService.php)                                                            |
| [`Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\LocationFilteringAdapter`](../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIteratorAdapter/LocationFilteringAdapter.php)              | [`LocationService::find()`](../../../../../ibexa/core/src/contracts/Repository/LocationService.php)                                                                                  |
| [`Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\LocationSearchAdapter`](../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIteratorAdapter/LocationSearchAdapter.php)                    | [`SearchService::findLocations()`](../../../../../ibexa/core/src/contracts/Repository/SearchService.php)                                                                    |
| [`Ibexa\Contracts\ProductCatalog\Iterator\BatchIteratorAdapter\AttributeDefinitionFetchAdapter`](../../../../../ibexa/product-catalog/src/contracts/Iterator/BatchIteratorAdapter/AttributeDefinitionFetchAdapter.php) | [`AttributeDefinitionServiceInterface::findAttributesDefinitions()`](../../../../../ibexa/product-catalog/src/contracts/AttributeDefinitionServiceInterface.php) |
| [`Ibexa\Contracts\ProductCatalog\Iterator\BatchIteratorAdapter\AttributeGroupFetchAdapter`](../../../../../ibexa/product-catalog/src/contracts/Iterator/BatchIteratorAdapter/AttributeGroupFetchAdapter.php)           | [`AttributeGroupServiceInterface::findAttributeGroups()`](../../../../../ibexa/product-catalog/src/contracts/AttributeGroupServiceInterface.php)                       |
| [`Ibexa\Contracts\ProductCatalog\Iterator\BatchIteratorAdapter\CurrencyFetchAdapter`](../../../../../ibexa/product-catalog/src/contracts/Iterator/BatchIteratorAdapter/CurrencyFetchAdapter.php)                       | [`CurrencyServiceInterface::findCurrencies()`](../../../../../ibexa/product-catalog/src/contracts/CurrencyServiceInterface.php)                                             |
| [`Ibexa\Contracts\ProductCatalog\Iterator\BatchIteratorAdapter\ProductTypeListAdapter`](../../../../../ibexa/product-catalog/src/contracts/Iterator/BatchIteratorAdapter/ProductTypeListAdapter.php)                   | [`ProductTypeServiceInterface::findProductTypes()`](../../../../../ibexa/product-catalog/src/contracts/ProductTypeServiceInterface.php)                                   |

## Repository filtering

You can use the `ContentService::find(Filter)` method to find content items or `LocationService::find(Filter)` to find locations by using a defined Filter.

`ContentService::find` returns an iterable [`Ibexa\Contracts\Core\Repository\Values\Content\ContentList`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentList.php) while `LocationService::find` returns an iterable [`Ibexa\Contracts\Core\Repository\Values\Content\LocationList`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/LocationList.php).

Filtering differs from search. It doesn't use the `SearchService` and isn't based on indexed data.

[`Ibexa\Contracts\Core\Repository\Values\Filter\Filter`](../../../../../ibexa/core/src/contracts/Repository/Values/Filter/Filter.php) enables you to configure a query by using chained methods to select criteria, sorting, limit, and offset.

For example, the following command lists all content items under the specified parent location and sorts them by name in descending order:

```php
// ...
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;

class FilterCommand extends Command
{
    // ...
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parentLocationId = (int)$input->getArgument('parentLocationId');

        $filter = new Filter();
        $filter
            ->withCriterion(new Criterion\ParentLocationId($parentLocationId))
            ->withSortClause(new SortClause\ContentName(Query::SORT_DESC));

        $result = $this->contentService->find($filter, []);

        $output->writeln('Found ' . $result->getTotalCount() . ' items');

        foreach ($result as $content) {
            $output->writeln($content->getName() ?? 'No content name');
        }

        return self::SUCCESS;
    }
}
```

The same Filter can be applied to find locations instead of content items, for example:

```php
// ...
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;

class FilterCommand extends Command
{
    // ...
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parentLocationId = (int)$input->getArgument('parentLocationId');

        $filter = new Filter();
        $filter
            ->withCriterion(new Criterion\ParentLocationId($parentLocationId))
            ->withSortClause(new SortClause\ContentName(Query::SORT_DESC));

        $result = $this->locationService->find($filter, []);

        $output->writeln('Found ' . $result->getTotalCount() . ' items');

        foreach ($result as $content) {
            $output->writeln($content->getContent()->getName());
        }

        return self::SUCCESS;
    }
}
```

> **Caution: Caution**
>
> The total count is the total number of matched items, regardless of pagination settings.

> **Tip: Repository filtering is SiteAccess-aware**
>
> Repository filtering is SiteAccess-aware, which means you can skip the second argument of the `find` methods. In that case languages from a current context are injected and added as a LanguageCode Criterion filter.

You can use the following methods of the Filter:

- `withCriterion` - add the first Criterion to the Filter
- `andWithCriterion` - add another Criterion to the Filter using a LogicalAnd operation. If this is the first Criterion, this method works like `withCriterion`
- `orWithCriterion` - add a Criterion using a LogicalOr operation. If this is the first Criterion, this method works like `withCriterion`
- `withSortClause` - add a Sort Clause to the Filter
- `sliceBy` - set limit and offset for pagination
- `reset` - remove all Criteria, Sort Clauses, and pagination settings

The following example filters for Folder content items under the parent location 2, sorts them by publication date and returns 10 results, starting from the third one:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;

$filter = new Filter();
$filter
    ->withCriterion(new Criterion\ContentTypeIdentifier('folder'))
    ->andWithCriterion(new Criterion\ParentLocationId(2))
    ->withSortClause(new SortClause\DatePublished(Query::SORT_ASC))
    ->sliceBy(10, 2);
```

> **Note: Search Criteria and Sort Clause availability**
>
> Not all Search Criteria and Sort Clauses are available for use in repository filtering.
>
> Only Criteria implementing [`Ibexa\Contracts\Core\Repository\Values\Filter\FilteringCriterion`](../../../../../ibexa/core/src/contracts/Repository/Values/Filter/FilteringCriterion.php) and Sort Clauses implementing [`Ibexa\Contracts\Core\Repository\Values\Filter\FilteringSortClause`](../../../../../ibexa/core/src/contracts/Repository/Values/Filter/FilteringSortClause.php) are supported.
>
> See [Search Criteria](../criteria_reference/search_criteria_reference/index.md) and [Sort Clause reference](../sort_clause_reference/sort_clause_reference/index.md) for details.

> **Tip: Tip**
>
> It's recommended to use an IDE that can recognize type hints when working with Repository Filtering. If you try to use an unsupported Criterion or Sort Clause, the IDE indicates an issue.

## Search in controller

You can use the `SearchService` or repository filtering in a controller, as long as you provide the required parameters. For example, in the code below, `locationId` is provided to list all children of a location by using the `SearchService`.

```php
// ...
use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\HttpFoundation\Response;

class CustomController extends Controller
{
    // ...
    public function showContentAction(int $locationId): Response
    {
        $query = new LocationQuery();
        $query->filter = new Criterion\ParentLocationId($locationId);

        $results = $this->searchService->findContentInfo($query);
        $items = [];
        foreach ($results->searchHits as $searchHit) {
            $items[] = $searchHit;
        }

        return $this->render('@ibexadesign/full/custom.html.twig', [
            'items' => $items,
        ]);
    }
}
```

The rendering of results is then relegated to [templates](../../templating/templates/templates/index.md) (lines 22-24).

When using Repository filtering, provide the results of `ContentService::find()` as parameters to the view:

```php
// ...
use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ParentLocationId;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Core\MVC\Symfony\View\ContentView;

class CustomFilterController extends Controller
{
    // ...
    public function showChildrenAction(ContentView $view): ContentView
    {
        $filter = new Filter();
        $filter
            ->withCriterion(new ParentLocationId($view->getLocation()->id));

        $view->setParameters(
            [
                'items' => $this->contentService->find($filter),
            ]
        );

        return $view;
    }
}
```

### Paginate search results

To paginate search or filtering results, it's recommended to use the [Pagerfanta library](https://github.com/BabDev/Pagerfanta) and [Ibexa DXP's adapters for it.](https://github.com/ibexa/core/blob/5.0/src/lib/Pagination/Pagerfanta/Pagerfanta.php)

```php
// ...
use Ibexa\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaginationController extends Controller
{
    // ...
    public function showContentAction(Request $request, int $locationId): Response
    {
        $query = new LocationQuery();
        $query->filter = new Criterion\ParentLocationId($locationId);

        $pager = new Pagerfanta(
            new ContentSearchAdapter($query, $this->searchService)
        );
        $pager->setMaxPerPage(3);
        $pager->setCurrentPage($request->get('page', 1));

        return $this->render(
            '@ibexadesign/full/custom_pagination.html.twig',
            [
                'totalItemCount' => $pager->getNbResults(),
                'pagerItems' => $pager,
            ]
        );
    }
}
```

Pagination can then be rendered for example using the following template:

```html+twig
{% for item in pagerItems %}
    <h2><a href={{ ibexa_path(item) }}>{{ ibexa_content_name(item) }}</a></h2>
{% endfor %}

{% if pagerItems.haveToPaginate() %}
    {{ pagerfanta(pagerItems, 'ibexa') }}
{% endif %}
```

For more information and examples, see [PagerFanta documentation](https://www.babdev.com/open-source/packages/pagerfanta/docs/3.x/usage).

#### Pagerfanta adapters

| Adapter class name                                                                                                              | Description                                                                                                                                                                                                                                                          |
| ------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`ContentSearchAdapter`](https://github.com/ibexa/core/blob/5.0/src/lib/Pagination/Pagerfanta/ContentSearchAdapter.php)         | Makes a search against passed Query and returns [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php) objects.                                                                  |
| [`ContentSearchHitAdapter`](https://github.com/ibexa/core/blob/5.0/src/lib/Pagination/Pagerfanta/ContentSearchHitAdapter.php)   | Makes a search against passed Query and returns [`Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchHit`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/Search/SearchHit.php) objects instead.                                               |
| [`LocationSearchAdapter`](https://github.com/ibexa/core/blob/5.0/src/lib/Pagination/Pagerfanta/LocationSearchAdapter.php)       | Makes a location search against passed Query and returns [`Ibexa\Contracts\Core\Repository\Values\Content\Location`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/Location.php) objects.                                                       |
| [`LocationSearchHitAdapter`](https://github.com/ibexa/core/blob/5.0/src/lib/Pagination/Pagerfanta/LocationSearchHitAdapter.php) | Makes a location search against passed Query and returns [`Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchHit`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/Search/SearchHit.php) objects instead.                                      |
| [`ContentFilteringAdapter`](https://github.com/ibexa/core/blob/5.0/src/lib/Pagination/Pagerfanta/ContentFilteringAdapter.php)   | Applies a Content filter and returns a [`Ibexa\Contracts\Core\Repository\Values\Content\ContentList`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentList.php) object.                                                                    |
| [`LocationFilteringAdapter`](https://github.com/ibexa/core/blob/5.0/src/lib/Pagination/Pagerfanta/LocationFilteringAdapter.php) | Applies a location filter and returns a [`Ibexa\Contracts\Core\Repository\Values\Content\LocationList`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/LocationList.php) object.                                                                 |
| `AttributeDefinitionListAdapter`                                                                                                | Makes a search for product attributes and returns an [`Ibexa\Contracts\ProductCatalog\Values\AttributeDefinition\AttributeDefinitionListInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/AttributeDefinition/AttributeDefinitionListInterface.php) object. |
| `AttributeGroupListAdapter`                                                                                                     | Makes a search for product attribute groups and returns an [`Ibexa\Contracts\ProductCatalog\Values\AttributeGroup\AttributeGroupListInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/AttributeGroup/AttributeGroupListInterface.php) object.          |
| `CurrencyListAdapter`                                                                                                           | Makes a search for currencies and returns a [`Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyListInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Currency/CurrencyListInterface.php) object.                                           |
| `CustomPricesAdapter`                                                                                                           | Makes a search for custom prices and returns a `CustomPrice` object.                                                                                                                                                                                                 |
| `CustomerGroupListAdapter`                                                                                                      | Makes a search for customer groups and returns a [`Ibexa\Contracts\ProductCatalog\Values\CustomerGroup\CustomerGroupListInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/CustomerGroup/CustomerGroupListInterface.php) object.                       |
| `ProductListAdapter`                                                                                                            | Makes a search for products and returns a [`Ibexa\Contracts\ProductCatalog\Values\Product\ProductListInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/ProductListInterface.php) object.                                                |
| `ProductTypeListAdapter`                                                                                                        | Makes a search for product types and returns a [`Ibexa\Contracts\ProductCatalog\Values\ProductType\ProductTypeListInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/ProductType/ProductTypeListInterface.php) object.                               |
| `RegionListAdapter`                                                                                                             | Makes a search for regions and returns a [`Ibexa\Contracts\ProductCatalog\Values\Region\RegionListInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Region/RegionListInterface.php) object.                                                    |
| `ShoppingListAdapter`                                                                                                           | Makes a search for shopping lists and returns a [`Ibexa\Contracts\ShoppingList\Value\ShoppingListCollectionInterface`](../../../../../ibexa/shopping-list/src/contracts/Value/ShoppingListCollectionInterface.php) object.                               |

## Complex search

For more complex searches, you need to combine multiple Criteria. You can do it using logical operators: `LogicalAnd`, `LogicalOr`, and `LogicalNot`.

```php
        $query = new LocationQuery();

        $query->query = new Criterion\LogicalAnd([
            new Criterion\Subtree($this->locationService->loadLocation($locationId)->pathString),
            new Criterion\ContentTypeIdentifier($contentTypeIdentifier),
        ]);

        $result = $this->searchService->findContentInfo($query);
        $output->writeln('Found ' . $result->totalCount . ' items');
        foreach ($result->searchHits as $searchHit) {
            $output->writeln($searchHit->valueObject->name);
        }
```

This example takes three parameters from a command — `$text`, `$contentTypeId`, and `$locationId`. It then combines them using `Criterion\LogicalAnd` to search for content items that belong to a specific subtree, have the chosen content type and contain the provided text (lines 3-6).

This also shows that you can get the total number of search results using the `totalCount` property of search results (line 9).

You can also nest different operators to construct more complex queries. The example below uses the `LogicalNot` operator to search for all content containing a given phrase that doesn't belong to the provided Section:

```php
$query->query = new Criterion\LogicalAnd([
    new Criterion\Subtree($this->locationService->loadLocation($locationId)->pathString),
    new Criterion\ContentTypeIdentifier($contentTypeIdentifier),
    new Criterion\FullText($text),
    new Criterion\LogicalNot(
        new Criterion\SectionIdentifier('Media')
    ),
]);
```

### Combine independent Criteria

Criteria are independent of one another. This can lead to unexpected behavior, for instance because content can have multiple locations.

For example, a content item has two locations: visible location A and hidden location B. You perform the following query:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LocationId;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Visibility;

$query = new LocationQuery();
$bLocationId = 12345;
$query->filter = new Criterion\LogicalAnd([
    new LocationId($bLocationId),
    new Visibility(Visibility::VISIBLE),
]);
```

The query searches for location B by using the [`LocationId` Criterion](../criteria_reference/locationid_criterion/index.md), and for visible content by using the [`Visibility` Criterion](../criteria_reference/visibility_criterion/index.md).

Even though the location B is hidden, the query finds the content because both conditions are satisfied:

- the content item has location B
- the content item is visible (it has the visible location A)

## Sort results

To sort the results of a query, use one of more [Sort Clauses](../sort_clause_reference/sort_clause_reference/index.md).

For example, to order search results by their publication date, from oldest to newest, and then alphabetically by content name, add the following Sort Clauses to the query:

```php
$query->sortClauses = [
    new SortClause\DatePublished(LocationQuery::SORT_ASC),
    new SortClause\ContentName(LocationQuery::SORT_DESC),
];
```

> **Tip: Tip**
>
> For the full list and details of available Sort Clauses, see [Sort Clause reference](../sort_clause_reference/sort_clause_reference/index.md).

## Aggregation

> **Caution: Feature support**
>
> Aggregation is only available in the Solr and Elasticsearch search engines.

With aggregations you can find the count of search results or other result information for each Aggregation type.

To do this, you use of the query's `$aggregations` property:

```php
$contentTypeTermAggregation = new ContentTypeTermAggregation('content_type');
$contentTypeTermAggregation->setLimit(5);
$contentTypeTermAggregation->setMinCount(10);

$query->aggregations[] = $contentTypeTermAggregation;
```

The name of the aggregation must be unique in the given query.

Access the results by using the `get()` method of the aggregation:

```php
$contentByType = $results->aggregations->get('content_type');
```

Aggregation results contain the name of the result and the count of found items:

```php
foreach ($contentByType as $contentType => $count) {
    $output->writeln($contentType->getName() . ': ' . $count);
}
```

With field aggregations you can group search results according to the value of a specific field. In this case the aggregation takes the content type identifier and the field identifier as parameters.

The following example creates an aggregation named `selection` that groups results according to the value of the `topic` field in the `article` content type:

```php
$query->aggregations[] = new SelectionTermAggregation('selection', 'blog_post', 'topic');
```

With term aggregation you can define additional limits to the results. The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

```php
$contentTypeTermAggregation = new ContentTypeTermAggregation('content_type');
$contentTypeTermAggregation->setLimit(5);
$contentTypeTermAggregation->setMinCount(10);
```

To use a range aggregation, you must provide a `ranges` array containing a set of `Range` objects that define the borders of the specific range sets.

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\IntegerRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;

$ranges = [
    Range::ofInt(1, 30),
    Range::ofInt(30, 60),
    Range::ofInt(60, null),
];

$query = new LocationQuery();
$query->aggregations[] = new IntegerRangeAggregation('range', 'person', 'age', $ranges);
```

> **Note: Note**
>
> The beginning of the range is included and the end is excluded, so a range between 1 and 30 includes value `1`, but not `30`.
>
> `null` means that a range doesn't have an end. In the example all values above (and including) 60 are included in the last range.

See [Aggregation reference](../aggregation_reference/aggregation_reference/index.md) for details of all available aggregations.

## Search with embeddings

> **Note: Feature support**
>
> Searching with embeddings requires a search engine that supports it, such as Elasticsearch or Solr 9.8.1+.

Embeddings are numerical representations that capture the meaning of text, images, or other content. AI providers generate embeddings by converting words or documents into lists of numbers, instead of treating them as plain text. Such lists, aka vectors, can then be compared to find content with similar meaning.

Searching with embeddings enables matching content based on meaning rather than exact text matches. Instead of comparing keywords, the system compares vectors that represent the semantic meaning of content and the query input.

> **Note: Taxonomy suggestions**
>
> Embedding queries have been introduced primarily to support the [Taxonomy suggestions](../../content_management/taxonomy/taxonomy/index.md#taxonomy-suggestions) feature, therefore embedding search integration is provided for `TaxonomyEmbedding`.

You can narrow down the search results, for example, by content type or location. To do this, combine searching with embeddings with filters. Repository search also respects the permissions of the current user.

An embedding query is represented by the [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQuery`](../../../../../ibexa/core/src/contracts/Repository/Values/Content/EmbeddingQuery.php) value object. The object encapsulates the embedding used for similarity search and optional search parameters such as filtering, pagination, aggregations, and result counting.

### Use embedding queries in search

Embedding queries are executed through the search API in the same way as other search requests. You build an `EmbeddingQuery` instance by using a builder and pass it to the search service.

This example shows a minimal embedding query executed directly through the search service:

```php
<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQueryBuilder;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchHit;
use Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderResolverInterface;
use Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ibexa:taxonomy:find-by-embedding',
    description: 'Finds content using a taxonomy embedding query.'
)]
final class FindByTaxonomyEmbeddingCommand extends Command
{
    public function __construct(
        private readonly SearchService $searchService,
        private readonly EmbeddingProviderResolverInterface $embeddingProviderResolver,
    ) {
        parent::__construct();
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);

        $embeddingProvider = $this->embeddingProviderResolver->resolve();
        $embedding = $embeddingProvider->getEmbedding('example_content');

        $query = EmbeddingQueryBuilder::create()
            ->withEmbedding(new TaxonomyEmbedding($embedding))
            ->setFilter(new ContentTypeIdentifier('article'))
            ->setLimit(10)
            ->setOffset(0)
            ->setPerformCount(true)
            ->build();

        $result = $this->searchService->findContent($query);

        $io->success(sprintf('Found %d items.', $result->totalCount));

        foreach ($result->searchHits as $searchHit) {
            assert($searchHit instanceof SearchHit);

            /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
            $content = $searchHit->valueObject;
            $contentInfo = $content->versionInfo->contentInfo;

            $io->writeln(sprintf(
                '%d: %s',
                $contentInfo->id,
                $contentInfo->name
            ));
        }

        return self::SUCCESS;
    }
}
```

For more information, see [Embeddings reference](../embeddings_reference/embeddings_reference/index.md).

## Search in trash

In the user interface, on the **Trash** screen, you can search for content items, and then sort the results based on different criteria. To search the trash with the API, use the `TrashService::findInTrash` method to submit a query for content items that are held in trash. Searching in trash supports a limited set of Criteria and Sort Clauses. For a list of supported Criteria and Sort Clauses, see [Search in trash reference](../search_in_trash_reference/index.md).

> **Note: Note**
>
> Searching through the trashed content items operates directly on the database, therefore you cannot use external search engines, such as Solr or Elasticsearch, and it's impossible to reindex the data.

```php
use Ibexa\Contracts\Core\Repository\TrashService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
//...
$query = new Query();

$query->filter = new Query\Criterion\ContentTypeId($contentTypeId);
$results = $this->trashService->findTrashItems($query);
foreach ($results->items as $trashedLocation) {
    $output->writeln($trashedLocation->getContentInfo()->name);
}
```

> **Caution: Caution**
>
> Make sure that you set the Criterion on the `filter` property. It's impossible to use the `query` property, because the search in trash operation filters the database instead of querying.
