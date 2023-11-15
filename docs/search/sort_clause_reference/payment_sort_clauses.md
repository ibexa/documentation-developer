---
description: Payment Sort Clauses
edition: commerce
---


# Payment Sort Clauses

Payment Sort Clauses are supported only by [Payment Search (`PaymentServiceInterface::findPayments`)](payment_api.md#get-multiple-payments).

By using Sort Clauses you can filter payments by specific attributes, for example: creation date, status, and so on.

| Sort Clause | Sorting based on |
|-----|-----|
|[Id](payment_id_sort_clause.md)|Payment ID|
|[Identifier](payment_identifier_sort_clause.md)|Payment identifier|
|[CreatedAt](payment_createdat_sort_clause.md)|Date and time when payment was created|
|[UpdatedAt](payment_updatedat_sort_clause.md)|Date and time when payment status was updated|
|[Status](payment_status_sort_clause.md)|Payment status|
