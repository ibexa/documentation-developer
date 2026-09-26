# Price Search Criteria reference

Price Search Criteria

Price Search Criteria are only supported by [Price Search (`ProductPriceServiceInterface::findPrices`)](../../../product_catalog/price_api/index.md#prices).

With these Criteria you can filter prices by currency, customer group, product, and more.

## Price Search Criteria

| Search Criterion                                                                                              | Search based on                                                                    |
| ------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| [Currency](../price_currency_criterion/index.md)           | Currency                                                                           |
| [CustomerGroup](../price_customergroup_criterion/index.md) | A customer group that the price applies to                                         |
| [IsBasePrice](../price_isbaseprice_criterion/index.md)     | Boolean that indicates whether the price is a base price                           |
| [IsCustomPrice](../price_iscustomprice_criterion/index.md) | Boolean that indicates whether the price is a custom price                         |
| [LogicalAnd](../price_logicaland_criterion/index.md)       | Logical AND criterion that matches if all the provided Criteria match              |
| [LogicalOr](../price_logicalor_criterion/index.md)         | Logical OR criterion that matches if at least one of the provided Criteria matches |
| [Product](../price_product_criterion/index.md)             | Product code                                                                       |
