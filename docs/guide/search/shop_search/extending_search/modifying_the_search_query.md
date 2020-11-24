# Modifying the search query [[% include 'snippets/commerce_badge.md' %]]

Sometimes you need to modify the [EshopQuery](../search_api.md) before it is sent to the search service.
The event listener handles this situation.
You can use it if you need to modify the search term, or add some sorting criteria.

For example, when searching for a book ISBN number that needs to be modified.
When a user searches for `2-245-5-4878-0`, you want to modify the search term to remove the `-` and search only for `224558780`.

`SearchController` already contains an event that is dispatched after the complete query is built.
If you want to modify it, you need to implement an event listener for your project.

In the following example you modify the sort criteria of a query if the query is empty
and if you detect that current sort criteria is relevance sorting (default).

You can use any [EshopQuery](../search_api.md) getter methods to check any condition or property
and then use any setter method to modify whatever you need.

``` php
use Siso\Bundle\SearchBundle\Api\Common\RelevanceSorting;
use Siso\Bundle\SearchBundle\Api\Common\SearchTermCondition;
use Siso\Bundle\SearchBundle\Event\PostBuildEshopQueryEvent;
use MyProject\Bundle\ProjectBundle\Api\Search\PriorityFieldSorting;

class EshopQueryListener
{
    /**
     * modifies the eshop query after it was build
     *
     * @param PostBuildEshopQueryEvent $event
     */
    public function onPostBuildEshopQuery(PostBuildEshopQueryEvent $event)
    {   
        /** all form parameters are stored here incl. the search context:
         *      - product
         *      - catalog
         *      - content
         */ 
        $params = $event->getParams();

        $eshopQuery = $event->getEshopQuery();
        $conditions = $eshopQuery->getConditions();

        foreach($conditions as $index => $condition) {
            if ($condition instanceof SearchTermCondition) {
                //if the search term is empty, sort additionally by the priority
                if ((($condition->searchTerm === '') || ($condition->searchTerm === '*')) &&
                    ($eshopQuery->getSortCriteria()[0] instanceof RelevanceSorting)) {
                        $eshopQuery->setSortCriteria(array(new PriorityFieldSorting(array('direction' => 'desc'))));
                }
            }
        }

        //modify the query by setting new conditions
        $eshopQuery->setConditions($conditions);
    }
} 
```

Service definition:

``` php
<parameter key="myproject.eshop_query_listener.class">MyProject\Bundle\ProjectBundle\EventListener\EshopQueryListener</parameter>

<service id="myproject.eshop_query_listener" class="%myproject.eshop_query_listener.class%">
    <tag name="kernel.event_listener" event="siso_search.post_build_eshop_query" method="onPostBuildEshopQuery" />
</service> 
```
