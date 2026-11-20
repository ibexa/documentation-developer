# ProductCategorySubtree Criterion

ProductCategorySubtree Search Criterion

The `ProductCategorySubtree` Search Criterion searches for products assigned to a given product category or any of its subcategories.

Unlike the [`ProductCategory` criterion](../productcategory_criterion/index.md), which matches products assigned to specific category IDs, `ProductCategorySubtree` matches the entire subtree rooted at the provided category, including all descendant categories.

## Arguments

- `taxonomyEntryId` - int representing the ID of the root taxonomy entry (product category) of the subtree to search within

## Example

### PHP

```php
<?php declare(strict_types=1);

use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductCategorySubtree;

$taxonomyEntryId = 42;
$criteria = new ProductCategorySubtree($taxonomyEntryId);

/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService */
$productQuery = new ProductQuery();
$productQuery->setQuery($criteria);
$results = $productService->findProducts($productQuery);
```
