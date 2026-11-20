# SymbolAttributeCriterion

SymbolAttribute Criterion

The `SymbolAttribute` Search Criterion searches for products by [symbol attribute](../../../product_catalog/attributes/symbol_attribute_type/index.md).

## Arguments

- `identifier` - identifier of the format
- `value` - array with the values to search for

## Example

### PHP

```php
<?php declare(strict_types=1);

use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalogSymbolAttribute\Search\Criterion\SymbolAttribute;

$query = new ProductQuery();
$query->setFilter(new SymbolAttribute('ean', ['5023920187205']));
/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService */
$results = $productService->findProducts($query);
```
