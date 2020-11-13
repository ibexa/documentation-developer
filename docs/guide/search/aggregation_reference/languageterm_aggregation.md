# LanguageTermAggregation

The [LanguageTermAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/LanguageTermAggregation.php) aggregates search results by the Content item's language.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\LanguageTermAggregation('language');
```
