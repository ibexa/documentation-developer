---
description: Learn how to use PHP and REST APIs to retrieve product data from Quable
month_change: false
---


# Quable API

As [[= pim_product_name =]] products are represented as [[= product_name =]] products, you can use the existing [Product APIs](product_api.md) to retrieve the product information.

[[= pim_product_name =]] is the source of truth about products and categories and you should only use the [[= product_name =]] APIs to read the information coming from [[= pim_product_name =]], but you can't use them to modify it.
To modify the information, use the [[[= pim_product_name =]] interface](https://www.quable.com) or the dedicated [[[= pim_product_name =]] APIs](https://developers.quable.com/quable-api/).

## REST API Usage

To learn how to work with [[= product_name =]] REST API, see [REST API reference](rest_api_usage.md).

You can use the following endpoints to retrieve product and category information:

- [Product REST API](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product)
- [Taxonomy REST API](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Taxonomy)

## PHP API Usage

### Retrieve products

To retrieve product information coming from [[= pim_product_name =]], use the same APIs as described in [Product API](product_api.md).

The following example shows how you can retrieve a single product:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 55, 57, remove_indent=True) =]]
```

### Search for products

Use [`ProductQuery`](product_api.md#getting-product-information) to search for multiple products:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 59, 68, remove_indent=True) =]]
```

When working with [[= pim_product_name =]] products, the following search criteria are supported:

|Search Criterion|Search based on|
|-----|-----|
|[CreatedAt](createdat_criterion.md)|Date and time when product was created|
|[LogicalAnd](logicaland_criterion.md)|Composite criterion combining multiple criteria with AND|
|[MatchAll](matchall_criterion.md)|All products|
|[ProductCategory](productcategory_criterion.md)|Product category assigned to product|
|[ProductCategorySubtree](productcategorysubtree_criterion.md)|Product category subtree|
|[ProductCode](productcode_criterion.md)|Product's code|
|[ProductName](productname_criterion.md)|Product's name|
|[ProductType](producttype_criterion.md)|Product type|
|[UpdatedAt](updated_at_criterion.md)|Date and time when product was last updated|

The following sort clauses are supported:

|Sort Clause|Sorting based on|
|-----|-----|
|[CreatedAt](createdat_sort_clause.md)|Date and time of the creation of a product|
|[ProductCode](productcode_sort_clause.md)|Product's code|
|[ProductName](productname_sort_clause.md)|Product's name|

### Manage stock and pricing

For information stored outside of [[= pim_product_name =]], such as [product availability](product_api.md#product-availability) or [pricing](price_api.md), you can use the existing services to manage them:

``` php {skip-validation} hl_lines="6 14"
// Manage availability
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 84, 89, remove_indent=True) =]]
// Manage prices
[[= include_file('code_samples/api/product_catalog/src/Command/ProductPriceCommand.php', 69, 75, remove_indent=True) =]]
```

For advanced pricing strategies, use the [Discounts API](discounts_api.md) to specify prices for [[= pim_product_name =]]'s products.
