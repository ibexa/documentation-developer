# Implement custom search condition [[% include 'snippets/commerce_badge.md' %]]

To create a custom search condition, implement the following classes:

### Step 1: Create new class that implements `ConditionInterface`

Create a value object which checks if all necessary information for this condition is set:

``` php
class CustomCondition extends ValueObject implements ConditionInterface
{
    /**
     * @var null|array $checkProperties
     */
    protected $checkProperties = array(
        array('name' => 'customString', 'mandatory' => true, 'type' => 'string'),
    );
 
    /**
     * @var string
     */
    protected $customString;
}
```

### Step 2: Create new handler class

You can use any Search Criteria here. The example uses `Query\Criterion\Visibility`:

```php
class CustomConditionHandler implements EzSearchClauseHandlerInterface
{
    /**
     * @param SearchClauseInterface $searchClause
     * @param Query $query
     */
    public function handleSearchClause(SearchClauseInterface $searchClause, Query $query)
    {
        if (!($query->query instanceof Query\Criterion\LogicalOperator)) {
            return;
        }
        $ezCriterion = new Query\Criterion\Visibility($searchClause->customString);
        $query->query->criteria[] = $ezCriterion;
    }
 
    /**
     * @param SearchClauseInterface $searchClause
     * @return bool
     */
    public function canHandle(SearchClauseInterface $searchClause)
    {
        return $searchClause instanceof CustomCondition;
    }
}
```

### Step 3: Register the service

Add configuration in `services.xml` to register the handler. The handler is then used whenever a Search Clause is an instance of `CustomCondition`.

``` xml
<parameter key="siso_search.search_clause_handler.custom.ezsolr.class">path\to\CustomConditionHandler</parameter>
 
<service id="siso_search.search_clause_handler.custom.ezsolr" class="%siso_search.search_clause_handler.custom.ezsolr.class%">
    <tag name="siso_search.search_clause_handler" type="ezsolr" />
</service>
```
