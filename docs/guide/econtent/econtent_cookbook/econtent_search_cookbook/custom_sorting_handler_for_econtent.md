# Custom sorting handler for eContent [[% include 'snippets/commerce_badge.md' %]]

This example shows how to create a custom sorting that uses priority field.

This creates a new sort criterion for use with Solr. You can specify the Solr field name for sorting.
In this example it will be a field that stores product priority, but it can be any Solr field you want.

## 1. Create a class

Create a new class that extends `AbstractSortCriterion`:

``` php
<?php
 
namespace MyProject\Bundle\ProjectBundle\Api\Search;
 
use Siso\Bundle\SearchBundle\Api\AbstractSortCriterion;
 
class PriorityFieldSorting extends AbstractSortCriterion
{
}
```

## 2. Create a handler class

Variable `$indexName` is the Solr field that will be used for sorting:

``` php
<?php

namespace MyProject\Bundle\ProjectBundle\Service\Search;

use Siso\Bundle\SearchBundle\Api\AbstractSortCriterion;
use Siso\Bundle\SearchBundle\Api\SearchClauseInterface;
use Siso\Bundle\SearchBundle\Api\SolariumSearchClauseHandlerInterface;
use Solarium\QueryType\Select\Query\Query;
use MyProject\Bundle\ProjectBundle\Api\Search\PriorityFieldSorting;

class PriorityFieldSortingHandler implements SolariumSearchClauseHandlerInterface
{
    /**
     * @param SearchClauseInterface $searchClause
     * @param Query $query
     */
    public function handleSearchClause(SearchClauseInterface $searchClause, Query $query)
    {
 
        $indexName = 'ses_product_ses_datamap_priority_value_i';
 
        $direction = $searchClause->getDirection() === AbstractSortCriterion::DESC
            ? Query::SORT_DESC
            : Query::SORT_ASC;
 
        $query->addSort($indexName, $direction);
    }
 
    /**
     * @param SearchClauseInterface $searchClause
     * @return bool
     */
    public function canHandle(SearchClauseInterface $searchClause)
    {
        return $searchClause instanceof PriorityFieldSorting;
    }
}
```

## 3. Register the class as a service

Register the handler as a service in `services.xml` by providing the namespace of the handler class
and adding the tag name to the service definition.

The handler is then used whenever the search clause is an instance of `PriorityFieldSorting`.

This means that when you add this search clause to `eshopQuery`, the method executes the handler.

``` xml
<parameter key="siso_search.search_sort_handler.priority.econtent.class">MyProject\Bundle\ProjectBundle\Service\Search\PriorityFieldSortingHandler</parameter>
  
<service id="siso_search.search_sort_handler.priority.econtent.class" class="%siso_search.search_sort_handler.priority.econtent.class%">
    <tag name="siso_search.search_clause_handler" type="econtent" />
</service>
```

You can now use the handler in the following way:

``` php
$query = new EshopQuery();
  
// Insert here all the query options you like.
  
// This is our new sorting criteria.
$query->setSortCriteria(
    array(
        new PriorityFieldSorting(
            array(
                'direction' => 'desc'
            )
        ),
    )
);
```

A query could have several sorting criteria:

``` php
$eshopQuery->setSortCriteria(
    array(
        new MyCustomSorting1(array('direction' => 'asc')),
        new MyCustomSorting2(array('direction' => 'desc')),
        new MyCustomSorting3(array('direction' => 'desc')),
        ...
    )
```

The order of the sorting criteria is important. In the example above the sorting is in the order they are set into the array.

!!! note "Modifying existing SortHandlers"

    Existing `SortHandlers` can't be overriden by simply extending them.
    If you need to change the behavior of a `SortHandler`, you must use the new implementation explicitly,
    that is instantiate the new class, as shown in the example above.
