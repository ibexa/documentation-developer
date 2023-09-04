---
description: Price IsCustomPrice Criterion
---

# Price IsCustomPrice Criterion

The `IsCustomPrice` Search Criterion searches for prices that are custom prices.

## Arguments

- `type` - string that represents a price type
- `customer_group` - string that represents a Customer Group code that the custom price applies to

## Limitations

The `IsCustomPrice` Criterion is not available in Solr or Elasticsearch engines.

## Example

### PHP

``` php
$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsCustomPrice('custom', 'customer_group_1')
);
```