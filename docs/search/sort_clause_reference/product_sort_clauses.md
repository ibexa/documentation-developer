---
description: Product Sort Clauses
page_type: reference
---

# Product Sort Clauses

Product Sort Clauses are supported by [Product Search (`ProductServiceInterface::findProduct`)](product_api.md#products).

By using Sort Clause you can filter product by specific attributes, for example: price, code, or availability.

Product Sort Clauses can also be used with `ProductVariantQuery` when wrapped in a [`ProductCriterionAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Content-Query-Criterion-ProductCriterionAdapter.html)
. See the [product variant search examples](../../pim/product_api.md#searching-variants-across-products) for more information.

| Sort Clause | Sorting based on |
|-----|-----|
|[BasePrice](baseprice_sort_clause.md)|Base product price|
|[CreatedAt](createdat_sort_clause.md)|Date and time of the creation of a product|
|[CustomPrice](customprice_sort_clause.md)|Custom product price|
|[ProductAvailability](productavailability_sort_clause.md)|Product's availability|
|[ProductCode](productcode_sort_clause.md)|Product's code|
|[ProductName](productname_sort_clause.md)|Product's name|
