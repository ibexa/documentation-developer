---
description: Price IsCustomPrice Search Criterion
---

# Price IsCustomPrice Criterion

The `IsCustomPrice` Search Criterion searches for prices that are custom prices.

## Arguments

This Criterion takes no arguments.

## Limitations

The `IsCustomPrice` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

``` php
$query = new PriceQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsCustomPrice()
);
```