---
description: Payment Method Search Criteria
edition: commerce
page_type: reference
---

# Payment Method Search Criteria reference

Payment Method Search Criteria are only supported by [Payment Method Search (`PaymentMethodService::findPaymentMethods`)](payment_method_api.md#get-multiple-payment-methods).

With these Criteria you can filter payment methods by their payment method identifier, payment method creation date, payment method type, status, and more.

## Payment method Search Criteria

|Search Criterion|Search based on|
|-----|-----|
|[CreatedAt](payment_method_createdat_criterion.md)|Date and time when payment method was created|
|[Enabled](payment_method_enabled_criterion.md)|Status of the payment method|
|[Id](payment_method_id_criterion.md)|Payment method ID|
|[Identifier](payment_method_identifier_criterion.md)|Payment method identifier|
|[LogicalAnd](payment_method_logicaland_criterion.md)|Logical AND criterion that matches if all the provided Criteria match|
|[LogicalOr](payment_method_logicalor_criterion.md)|Logical OR criterion that matches if at least one of the provided Criteria matches|
|[Name](payment_method_name_criterion.md)|Payment method name|
|[Type](payment_method_type_criterion.md)|Type of the payment method|
|[UpdatedAt](payment_method_updatedat_criterion.md)|Date and time when payment method status was updated|
