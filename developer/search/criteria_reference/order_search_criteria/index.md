# Order Search Criteria reference

Order Search Criteria

Editions: Commerce

Order Search Criteria are only supported by [Order Search (`OrderService::findOrders`)](../../../commerce/order_management/order_management_api/index.md#get-multiple-orders).

With these Criteria you can filter orders, for example, by their order identifier, order creation date, order status, customer name, or customer status.

## Order Search Criteria

| Search Criterion                                                                                                                  | Search based on                           |
| --------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------- |
| [CompanyNameCriterion](../order_company_name_criterion/index.md)               | Name of the company                       |
| [CreatedAtCriterion](../order_created_criterion/index.md)                      | Date and time when order was created      |
| [CurrencyCodeCriterion](../order_currency_code_criterion/index.md)             | Currency code                             |
| [CustomerNameCriterion](../order_customer_name_criterion/index.md)             | Customer's user name                      |
| [IdentifierCriterion](../order_identifier_criterion/index.md)                  | Order identifier                          |
| [IsCompanyAssociatedCriterion](../order_company_associated_criterion/index.md) | Whether the customer represents a company |
| [OwnerCriterion](../order_owner_criterion/index.md)                            | Owner based on the user reference         |
| [PriceCriterion](../order_price_criterion/index.md)                            | Total value of the order                  |
| [SourceCriterion](../order_source_criterion/index.md)                          | Source of the order                       |
| [StatusCriterion](../order_status_criterion/index.md)                          | Status of the order                       |
