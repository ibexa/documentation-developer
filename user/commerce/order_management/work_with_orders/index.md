# Work with orders

Review order information, change order status.

Editions: Commerce

In Ibexa DXP, you can view a list of orders and modify their statuses on the **Orders** screen. By default, depending on your permissions, you can access your own orders, or all the orders that exist in the system.

## Filter orders in order list

1. In the left panel, go to **Commerce** -> **Orders**.
2. Narrow down the list of displayed orders in one of the following ways:
   - search for orders by typing part of customer or company name, or order identifier in the search box
   - filter orders by selecting one or more filters

Available filters are:

- Statuses - multiselect list of order statuses, by default: Pending, Processing, Completed, Cancelled

> **Note: Order statuses**
>
> Order statuses visible in the **Status** filter field are defined in the [Order workflow](../../../../developer/commerce/order_management/configure_order_management/index.md#configure-order-processing-workflow).

- Created - a range of dates between which the order was created
- Client type - either B2B or B2C client
- Order source - the store from which the order comes
- Total value - a range of values that includes the total value of the order, in a selected currency
- Currency - the currency in which the order was made

![Order list](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/order_list.png)

## View order details

To view the details of an order, click its line in the order list.

On the order details screen, you can view more information about the order, such as customer, payment, and shipment details.

![Order detail view](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/order_detail_view.png)

In the **Items** tab you can see a list of products included in the order.

![Viewing products included in the order](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/order_detail_items.png)

The fields have the following meaning:

- **Subtotal (net)** - a sum of all product prices without taxes
- **Shipping cost** - a net cost of the selected shipping method
- **Taxes** - a total value of all taxes, including those that apply to the selected shipping method and the products
- **Total value (gross)** - a total value of the order, including all discounts, taxes, and service charges

> **Note: Ordering virtual products**
>
> If the order includes only virtual products then the Shipment and Shipping address sections aren't available. Virtual products don't require shipment when they're the only product in a purchase.

## Change order status

If your [user role](../../../permission_management/work_with_permissions/index.md) includes the `Order/Update` permission, you can change the status of an existing order: confirm it if the order has "Pending" status, or complete it when it's in "Processing" status. With the `Order/Cancel` permission, you can cancel an existing order.

> **Note: Canceling orders**
>
> When you create an order, stocks are reduced for the products on that order. When you cancel an order, the stocks are reverted back to their original values.
