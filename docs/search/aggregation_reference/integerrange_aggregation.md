---
description: IntegerRangeAggregation
---

# IntegerRangeAggregation

The field-based [IntegerRangeAggregation](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-IntegerRangeAggregation.html) aggregates search results by the value of the Integer field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;

$query = new Query();
$query->aggregations[] = new Aggregation\Field\IntegerRangeAggregation(
    'integer',
    'product',
    'amount',
    [
    Range::ofInt(null, 12),
    Range::ofInt(12, 24),
    Range::ofInt(24, null),
]
);
```
