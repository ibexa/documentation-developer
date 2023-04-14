---
description: Payment Search Criteria
edition: commerce
---

# Payment Search Criteria reference

Payment Search Criteria are part of [Search Criteria](search_criteria_reference.md) and they are supported only by Payment Search.

With these criteria you can filter payments by their payment identifier, payment creation date, payment status, payment method, order, etc.

## Payment search criteria

|Search Criterion|Search based on|
|-----|-----|
|[CreatedAtCriterion](payment_createdat_criterion.md)|Date and time when payment was initiated|
|[CurrencyCriterion](payment_currency_criterion.md)|Currency code|
|[Id](payment_id_criterion.md)|Payment ID|
|[IdentifierCriterion](payment_identifier_criterion.md)|Payment identifier|
|[LogicalAndCriterion](payment_logicaland_criterion.md)|Logical AND criterion that matches if all the provided Criteria match|
|[LogicalOrCriterion](payment_logicalor_criterion.md)|Logical OR criterion that matches if at least one of the provided Criteria matches|
|[OrderCriterion](payment_order_criterion.md)|ID of an associated order|
|[PaymentMethodCriterion](payment_payment_method_criterion.md)|Payment method applied to the payment|
|[PriceCriterion](payment_price_criterion.md)|Total value of the payment|
|[StatusCriterion](payment_status_criterion.md)|Status of the payment|
|[UpdatedAtCriterion](payment_updatedat_criterion.md)|Date and time when payment status was updated|
