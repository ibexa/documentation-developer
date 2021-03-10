# Order history [[% include 'snippets/commerce_badge.md' %]]

Order history enables you to see an overview and details of your orders or other documents.
You can see documents based on online purchases as well as orders placed e.g. by a telephone call.

Order history is available in the user menu under **Your documents**,
and through the `/orderhistory` route.

To access order history, the User must have the `siso_policy/orderhistory_view` Policy.

Depending on whether you have an ERP system connected, order history displays documents from ERP,
or [local documents](order_history_local_orders.md).

On the detail page you can see the buyer, delivery address, ordered items and other details about the order,
such as status, delivery and payment information.

![](../img/orderhistory.png)

Each document has a detail page:

![](../img/orderhistory_detail.png)

If a product is still available in the shop, you can add it to the basket again. 

Order history supports different document types:

- order
- invoice
- delivery note
- credit memo
