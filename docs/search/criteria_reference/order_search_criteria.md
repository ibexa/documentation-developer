---
description: Order Search Criteria
edition: commerce
---

# Order Search Criteria reference

Order Search Criteria are only supported by [Order Search (`OrderService::findOrders`)](order_management_api.md#get-multiple-orders).

With these Criteria you can filter orders, for example, by their order identifier, order creation date, order status, customer name, or customer status.

## Order Search Criteria

|Search Criterion|Search based on|
|-----|-----|
|[CompanyNameCriterion](order_company_name_criterion.md)|Name of the company|
|[CreatedAtCriterion](order_created_criterion.md)|Date and time when order was created|
|[CurrencyCodeCriterion](order_currency_code_criterion.md)|Currency code|
|[CustomerNameCriterion](order_customer_name_criterion.md)|Customer's user name|
|[IdentifierCriterion](order_identifier_criterion.md)|Order identifier|
|[IsCompanyAssociatedCriterion](order_company_associated_criterion.md)|Whether the customer represents a company|
|[OwnerCriterion](order_owner_criterion.md)|Owner based on the user reference|
|[PriceCriterion](order_price_criterion.md)|Total value of the order|
|[SourceCriterion](order_source_criterion.md)|Source of the order|
|[StatusCriterion](order_status_criterion.md)|Status of the order|
