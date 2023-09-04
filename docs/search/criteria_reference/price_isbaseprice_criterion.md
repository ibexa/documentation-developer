---
description: Price IsBasePrice Criterion
---

# Price IsBasePrice Criterion

The `IsBasePrice` Search Criterion searches for prices that are base prices.

## Arguments

- `type` - string that represents a price type
- `base` - Boolean that represents whether to search for base prices or non-base prices

## Limitations

The `IsBasePrice` Criterion is not available in Solr or Elasticsearch engines.

## Example

### PHP

``` php
$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsBasePrice('base', true)
);
```