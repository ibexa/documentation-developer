# DateMetadataRangeAggregation

The [DateMetadataRangeAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-CountryTermAggregation.html) aggregates search results by the value of the Content items' date metadata.

## Arguments

- `name` - name of the Aggregation object
- `type` - string representing the type of the Aggregation (`MODIFIED` or `PUBLISHED`)
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\DateMetadataRangeAggregation('date_metadata', Aggregation\DateMetadataRangeAggregation::PUBLISHED,
    [
        new Query\Aggregation\Range(null, new DateTime('2020-06-01')),
        new Query\Aggregation\Range(new DateTime('2020-06-01'), new DateTime('2020-12-31')),
        new Query\Aggregation\Range(new DateTime('2020-12-31'), null),
    ]);
```
