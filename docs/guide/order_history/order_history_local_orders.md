# Local orders [[% include 'snippets/commerce_badge.md' %]]

You can display user documents even if the shop is not connected to an ERP system.
In this case, the user sees the documents [stored locally in the shop](../../guide/checkout/local_orders.md).

The shop only stores local data for orders, so only the `order` document type is displayed.

The use of local documents is enabled with the `use_local_documents` configuration parameter:

``` yaml
siso_order_history.default.use_local_documents: false
```

## Invoices for local orders

Invoices for local orders are available only for the current user.

Order history details contain a link in the header to the invoice page:

![](../img/orderhistory_invoice.png)

### Order history list

To show the invoice link in a new column of the table, use the following configuration:

``` yaml
siso_order_history.default.default_list_fields:
    order:  
        # ...
        - SesExtension_Invoice
```

The `EshopBundle/Resources/views/Invoice/show.html.twig` template renders the invoice view and the invoice PDF.
