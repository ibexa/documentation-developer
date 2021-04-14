## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods.
The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

``` php
$query->aggregations[0]->setLimit(5);
$query->aggregations[0]->setMinCount(10);
```
