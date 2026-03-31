---
description: Product Sort Clauses
page_type: reference
---

# Product Sort Clauses

Product Sort Clauses are only supported by [Product Search (`ProductServiceInterface::findProduct`)](product_api.md#products).

By using Sort Clause you can filter product by specific attributes, for example: price, code, or availability.

To sort products coming from [[= pim_product_name =]] PIM, see [[[= pim_product_name =]] Search API](../../product_catalog/quable/quable_api.md#search-for-products) for a list of supported sort clauses.

| Sort Clause | Sorting based on |
|-----|-----|
|[BasePrice](baseprice_sort_clause.md)|Base product price|
|[CreatedAt](createdat_sort_clause.md)|Date and time of the creation of a product|
|[CustomPrice](customprice_sort_clause.md)|Custom product price|
|[ProductAvailability](productavailability_sort_clause.md)|Product's availability|
|[ProductCode](productcode_sort_clause.md)|Product's code|
|[ProductName](productname_sort_clause.md)|Product's name|
