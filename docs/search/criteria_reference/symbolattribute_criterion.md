---
description: SymbolAttribute Criterion
---

# SymbolAttributeCriterion

The `SymbolAttribute` Search Criterion searches for products by symbol attribute.

## Arguments

- `value` - string representing the attribute value

## Example

### PHP

``` php
$query = new ProductQuery();
$query->setFilter(new SymbolAttribute('ean', '5023920187205'));
// ...
$results = $productService->findProducts($query);
```