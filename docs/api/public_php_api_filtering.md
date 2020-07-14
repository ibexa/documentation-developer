# Repository filtering

You can use the `ContentService::find(Filter)` method to find Content items or
`LocationService::find(Filter)` to find Locations using a defined Filter.

`ContentService::find` returns iterable [`ContentList`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.1.0/eZ/Publish/API/Repository/Values/Content/ContentList)
while `LocationService::find` returns iterable [`LocationList`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.1.0/eZ/Publish/API/Repository/Values/Content/LocationList).

Filtering differs from search. It does not use the `SearchService` and is not based on indexed data.
This means it does not have the latency a search engine has when indexing data.  

[`Filter`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.1.0/eZ/Publish/API/Repository/Values/Filter/Filter.php)
enables you to configure a query using chained methods (a.k.a. fluent setter) to select criteria, sorting, limit and offset.

For example, the following command lists all Content items under the specified parent Location
and sorts them in descending order by name:

``` php hl_lines="15-18"
// ...
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\Values\Filter\Filter;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

class FilterCommand extends Command
{
    // ...
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parentLocationId = (int)$input->getArgument('parent-location-id');

        $filter = new Filter();
        $filter
            ->withCriterion(new Criterion\ParentLocationId($parentLocationId))
            ->withSortClause(new SortClause\ContentName(Query::SORT_DESC));

        $result = $this->contentService->find($filter, []);

        $output->writeln('Found ' . $result->getTotalCount() . ' items');

        foreach ($result as $content) {
            $output->writeln($content->getName());
        }

        return self::SUCCESS;
    }
}
```

The same Filter can be applied to find Locations instead of Content items, for example:

``` php hl_lines="19"
// ...
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\Values\Filter\Filter;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

class FilterCommand extends Command
{
    // ...
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parentLocationId = (int)$input->getArgument('parent-location-id');
        $filter = new Filter();
        $filter
            ->withCriterion(new Criterion\ParentLocationId($parentLocationId))
            ->withSortClause(new SortClause\ContentName(Query::SORT_DESC));

        $result = $this->locationService->find($filter, []);

        $output->writeln('Found ' . $result->totalCount . ' items');

        foreach ($result as $location) {
            $output->writeln($location->getContent()->getName());
        }

        return self::SUCCESS;
    }
}
```

Notice that the total number of items is retrieved differently depending on whether we're dealing
with `ContentList` or `LocationList`. 

!!! caution

    The total count is **a total number of matched items**, regardless of pagination settings.
    
!!! tip "Repository filtering is SiteAccess-aware."

    Repository filtering is SiteAccess-aware, which means that the second argument of its respective
    `find` methods can be skipped. In that case languages from a current context are injected and
    added as a LanguageCode Criterion filter. 
    
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
    
    Only Criteria implementing [`FilteringCriterion`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.1.0/eZ/Publish/SPI/Repository/Values/Filter/FilteringCriterion.php)
    and Sort Clauses implementing [`FilteringSortClause`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.1.0/eZ/Publish/SPI/Repository/Values/Filter/FilteringSortClause.php)
    are supported.

    See to [Search Criteria](../guide/search/search_criteria_reference.md)
    and [Sort Clause reference](../guide/search/sort_clause_reference.md) for details.
    
!!! tip

    It's recommended to use an IDE capable of recognizing type hints when working with Repository filtering.
    In case of using unsupported Criterion or Sort Clause, such IDE will immediately hint an issue. 

## Filtering in a controller

You can use the Repository filtering in a controller, as long as you provide the required parameters.
For example, in the code below `locationId` is provided to list all children of a Location using the 
`ContentService::find`. Provide the method results as a View parameter:

``` php hl_lines="19"
// ...
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\ParentLocationId;
use eZ\Publish\API\Repository\Values\Filter\Filter;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;

class CustomController extends Controller
{
    // ...
    public function showChildrenAction(ContentView $view): ContentView
    {
        $filter = new Filter();
        $filter
            ->withCriterion(new ParentLocationId($view->getLocation()->id))

        $view->setParameters(
            [
                'items' => $this->contentService->find($filter),
            ]
        );

        return $view;
    }
}
```

The rendering of results is then relegated to [templates](../guide/templates.md) (lines 20-22).
