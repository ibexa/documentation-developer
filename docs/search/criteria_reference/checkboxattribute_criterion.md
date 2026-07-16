---
description: CheckboxAttribute Search Criterion
---

# CheckboxAttribute Criterion

The `CheckboxAttribute` Search Criterion searches for products by the value of their checkbox attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - bool representing the attribute value

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\CheckboxAttribute('automatic', true)
);
```
