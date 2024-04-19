---
description: Order Sort Clauses
edition: commerce
---

---

# Order Sort Clauses

Order Sort Clauses are only supported by [Order Search (`OrderService::findOrders`)](order_management_api.md#get-multiple-orders).

By using Sort Clauses you can filter orders by specific attributes, for example: creation date, status, etc.

| Sort Clause | Sorting based on |
|-----|-----|
|[Id](order_id_sort_clause.md)|Order ID|
|[Created](order_created_sort_clause.md)|Date and time when order was created|
|[Updated](order_updated_sort_clause.md)|Date and time when order status was updated|
|[Status](order_status_sort_clause.md)|Order status|
