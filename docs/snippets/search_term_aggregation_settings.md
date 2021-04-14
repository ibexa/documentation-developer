## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods.
The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

``` php
$aggregation = new //...
$aggregation->setLimit(5);
$aggregation->setMinCount(10);
```
