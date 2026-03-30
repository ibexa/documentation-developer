description: Use 
month_change: true
---


# Quable API

As [[= pim_product_name =]] products are represented as [[= product_name =]] products, you can use the existing [Product APIs](product_api.md) to retrieve the product information.

[[= pim_product_name =]] is the source of truth about products and categories and you can should only use the [[= product_name =]] APIs to read the information coming from [[= pim_product_name =]], but you can't use them to modify it.
To modify the information, use the [[[= pim_product_name =]] interface](https://quable.com) or the dedicated [[[= pim_product_name =]]](https://developers.quable.com/quable-api/) APIs.

## REST API Usage

To learn how to work with [[= product_name =]] REST API, see [REST API reference](rest_api_usage.md).

You can use the following endpoints to retrive product and category information:

- [Product REST API](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product)
- [Taxonomy REST API](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Taxonomy)

## PHP API Usage

### Retrieve products

To retrive product information coming from [[= pim_product_name =]], use the same APIs as described in [Product API](product_api.md).

The following example shows how you can retrieve a single product, or multiple ones:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 54, 68) =]]
```

### Search for products

When working with [[= pim_product_name =]] products, the following search criteria are supported:

- 

The following sort clauses are supported:

| Sort clause | Comment |
| --------- | ------- |
| ProductCode  |
| ProductName
| CreatedAt |

  Supported criteria: , , LogicalAnd, , , , , , CreatedAt, , and limited LogicalOr (only admin search pattern: ProductCode(['x']) OR ProductName('*x*')).


● Currently 3 sort clauses are supported:
\ProductCode → order[id]
   - ...SortClause\ProductName → order[name]
   - ...SortClause\CreatedAt → order[dateCreated]



### Manage stock and pricing

For information that is stored outside of [[= pim_product_name =]], such as [product availability](product_api.md#product-availability) or [pricing](price_api.md), you can use the existing services to manage them:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 84, 89, remove_indent=True) =]]
```
