---
description: Order history lets the user check the historical records of all their orders.
edition: commerce
---

# Order history

The **Order History** screen enables you to see an overview and details of your orders or other documents.
You can see documents related to online purchases as well as orders placed, for example, by phone.

Order history supports different document types:

- order
- invoice
- delivery note
- credit memo

Order history is available through the `/orderhistory` route.

To access order history, the User must have the `siso_policy/orderhistory_view` Policy.

![](orderhistory.png)

Each document has a detail page, where you can see the detailed information, such as the buyer, delivery address, ordered items, status, delivery and payment information:

![](orderhistory_detail.png)

If a product is still available in the shop, you can add it to the basket again. 

## Invoices

In the header of the order history details page, there is a link to the invoice page:

![](orderhistory_invoice.png)

### Order history list

To show the invoice link in a new column of the table, use the following configuration:

``` yaml
ibexa_commerce_order_history.default.default_list_fields:
    order:  
        # ...
        - SesExtension_Invoice
```

The `Eshop/Resources/views/Invoice/show.html.twig` template renders the invoice view and the invoice PDF.
