---
description: FloatRangeAggregation
---

# FloatRangeAggregation

The field-based [FloatRangeAggregation](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-FloatRangeAggregation.html) aggregates search results by the value of the Float field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;

$query = new Query();
$query->aggregations[] = new Aggregation\Field\FloatRangeAggregation(
    'float',
    'product',
    'weight',
    [
    Range::ofFloat(null, 0.25),
    Range::ofFloat(0.25, 0.75),
    Range::ofFloat(0.75, null),
]
);
```
