---
description: Price IsBasePrice Search Criterion
---

# Price IsBasePrice Criterion

The `IsBasePrice` Search Criterion searches for prices that are base prices.

## Arguments

This Criterion takes no arguments.

## Limitations

The `IsBasePrice` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

``` php
$query = new PriceQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsBasePrice()
);
```