---
description: CurrencyCode Search Criterion
---

# CurrencyCode Criterion

The `CurrencyCodeCriterion` Search Criterion searches for currencies by their codes.

## Arguments

- `code` - string representing the currency code

## Limitations

The `CurrencyCodeCriterion` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyQuery;
use Ibexa\Contracts\ProductCatalog\Values\Currency\Query\Criterion\CurrencyCodeCriterion;

$query = new CurrencyQuery(
    new CurrencyCodeCriterion('EUR')
);
```
