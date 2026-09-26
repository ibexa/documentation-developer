# Product Sort Clauses

Product Sort Clauses

Product Sort Clauses are only supported by [Product Search (`ProductServiceInterface::findProduct`)](../../../product_catalog/product_api/index.md#products).

By using Sort Clause you can filter product by specific attributes, for example: price, code, or availability.

To sort products coming from Quable PIM, see [Quable Search API](../../../product_catalog/quable/quable_api/index.md#search-for-products) for details about the add-on.

| Sort Clause                                                                                                              | Sorting based on                           | Local product catalog | Quable PIM |
| ------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------ | --------------------- | ---------- |
| [BasePrice](../baseprice_sort_clause/index.md)                     | Base product price                         | Yes                   |            |
| [CreatedAt](../createdat_sort_clause/index.md)                     | Date and time of the creation of a product | Yes                   | Yes        |
| [CustomPrice](../customprice_sort_clause/index.md)                 | Custom product price                       | Yes                   |            |
| [ProductAvailability](../productavailability_sort_clause/index.md) | Product's availability                     | Yes                   |            |
| [ProductCode](../productcode_sort_clause/index.md)                 | Product's code                             | Yes                   | Yes        |
| [ProductName](../productname_sort_clause/index.md)                 | Product's name                             | Yes                   | Yes        |
