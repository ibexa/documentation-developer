---
description: ProductCategorySubtree Search Criterion
month_change: false
---

# ProductCategorySubtree Criterion

The `ProductCategorySubtree` Search Criterion searches for products assigned to a given product category or any of its subcategories.

Unlike the [`ProductCategory` criterion](productcategory_criterion.md), which matches products assigned to specific category IDs, `ProductCategorySubtree` matches the entire subtree rooted at the provided category, including all descendant categories.

## Arguments

- `taxonomyEntryId` - int representing the ID of the root taxonomy entry (product category) of the subtree to search within

## Example

### PHP

``` php
[[= include_code('code_samples/back_office/search/src/Query/ProductCategorySubtreeQuery.php') =]]
```
