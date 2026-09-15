---
description: Product Sort Clauses
page_type: reference
---

# Product Sort Clauses

Product Sort Clauses set the order of the products returned by product search.

You use them over the REST API, in the `SortClauses` element of the payload of the
[`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request.
Each Sort Clause takes the sorting direction as its value, either `ascending` or `descending`.

To sort products coming from [[= pim_product_name =]], see [[[= pim_product_name =]]](../../product_catalog/quable/quable.md) for details about the add-on.

| Sort Clause | Sorting based on | Local product catalog | [[= pim_product_name =]] |
|-----|-----|-----|-----|
|[CreatedAt](createdat_sort_clause.md)|Date and time of the creation of a product| &#10004;| &#10004;|
|[ProductAvailability](productavailability_sort_clause.md)|Product's availability| &#10004;| |
|[ProductCode](productcode_sort_clause.md)|Product's code| &#10004;| &#10004;|
|[ProductName](productname_sort_clause.md)|Product's name| &#10004;| &#10004;|
