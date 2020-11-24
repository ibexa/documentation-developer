# Implement custom sorting option for search [[% include 'snippets/commerce_badge.md' %]]

To create a custom sorting option, implement the following classes:

### Step 1: Create new class that extends `AbstractSortCriterion`

Create a value object which checks if all necessary information for this condition is set:

``` php
class CustomFieldSorting extends AbstractSortCriterion
{
}
```

### Step 2: Create new handler class

``` php
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause\Field;
 
 
class CustomFieldSortingHandler implements EzSearchClauseHandlerInterface
{
    /**
     * @param SearchClauseInterface $searchClause
     * @param Query $query
     */
    public function handleSearchClause(SearchClauseInterface $searchClause, Query $query)
    {
        $field = new Field('ses_custom_field', 'ext_ses_custom_field_f');
        $query->sortClauses[] = $field;
    }
 
    /**
     * @param SearchClauseInterface $searchClause
     * @return bool
     */
    public function canHandle(SearchClauseInterface $searchClause)
    {
        return $searchClause instanceof CustomFieldSorting;
    }
}
```

### Step 3: Register the service

Add configuration in `services.xml` to register the handler. The handler is then used whenever a Search Clause is an instance of `CustomFieldSorting`.

``` xml
<parameter key="siso_search.search_clause_handler.custom_sort.ezsolr.class">path\to\CustomFieldSorting</parameter>
 
<service id="siso_search.search_sort_handler.custom_sort.ezsolr" class="%siso_search.search_sort_handler.custom_sort.ezsolr.class%">
    <tag name="siso_search.search_clause_handler" type="ezsolr" />
</service>
```

#### Multiple sorting criteria

A query can have several sorting criteria. The order of the sorting criteria is important.
In the following example the sorting is performed in the order they are placed in the array:

```php
$eshopQuery->setSortCriteria(
    array(
        new MyCustomSorting1(array('direction' => 'asc')),
        new MyCustomSorting2(array('direction' => 'desc')),
        new MyCustomSorting3(array('direction' => 'desc')),
        ...
    )
)
```
