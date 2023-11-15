---
description: Payment Search Criteria
edition: commerce
page_type: reference
---

# Payment Search Criteria reference

Payment Search Criteria are supported only by [Payment Search (`PaymentServiceInterface::findPayments`)](payment_api.md#get-multiple-payments).

With these Criteria you can filter payments by their payment identifier, payment creation date, payment status, payment method, order, and so on.

## Payment Search Criteria

|Search Criterion|Search based on|
|-----|-----|
|[CreatedAt](payment_createdat_criterion.md)|Date and time when payment was created|
|[Currency](payment_currency_criterion.md)|Currency code|
|[Id](payment_id_criterion.md)|Payment ID|
|[Identifier](payment_identifier_criterion.md)|Payment identifier|
|[LogicalAnd](payment_logicaland_criterion.md)|Logical AND criterion that matches if all the provided Criteria match|
|[LogicalOr](payment_logicalor_criterion.md)|Logical OR criterion that matches if at least one of the provided Criteria matches|
|[Order](payment_order_criterion.md)|ID of an associated order|
|[PaymentMethod](payment_payment_method_criterion.md)|Payment method applied to the payment|
|[Status](payment_status_criterion.md)|Status of the payment|
|[UpdatedAt](payment_updatedat_criterion.md)|Date and time when payment status was updated|
