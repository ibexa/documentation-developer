# Payment Search Criteria reference

Payment Search Criteria

Editions: Commerce

Payment Search Criteria are only supported by [Payment Search (`PaymentServiceInterface::findPayments`)](../../../commerce/payment/payment_api/index.md#get-multiple-payments).

With these Criteria you can filter payments by their payment identifier, payment creation date, payment status, payment method, order, and more.

## Payment Search Criteria

| Search Criterion                                                                                                 | Search based on                                                                    |
| ---------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| [CreatedAt](../payment_createdat_criterion/index.md)          | Date and time when payment was created                                             |
| [Currency](../payment_currency_criterion/index.md)            | Currency code                                                                      |
| [Id](../payment_id_criterion/index.md)                        | Payment ID                                                                         |
| [Identifier](../payment_identifier_criterion/index.md)        | Payment identifier                                                                 |
| [LogicalAnd](../payment_logicaland_criterion/index.md)        | Logical AND criterion that matches if all the provided Criteria match              |
| [LogicalOr](../payment_logicalor_criterion/index.md)          | Logical OR criterion that matches if at least one of the provided Criteria matches |
| [Order](../payment_order_criterion/index.md)                  | ID of an associated order                                                          |
| [PaymentMethod](../payment_payment_method_criterion/index.md) | Payment method applied to the payment                                              |
| [Status](../payment_status_criterion/index.md)                | Status of the payment                                                              |
| [UpdatedAt](../payment_updatedat_criterion/index.md)          | Date and time when payment status was updated                                      |
