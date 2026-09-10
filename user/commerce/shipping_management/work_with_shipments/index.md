# Work with shipments

Work with shipments and view shipment details.

Editions: Commerce

In Ibexa DXP, on the **Shipments** screen, you can view a list of shipments and modify their statuses. You can access shipments for your own orders or all the shipments that exist in the system, depending on your permissions.

## View shipment status

Each shipment has a status due to the stage it's currently at.

Available statuses are:

- Pending
- Ready to ship
- Shipped
- Delivered
- Cancelled

![Shipment list](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/shipment_list.png)

> **Note: Shipment statuses**
>
> Shipment statuses visible in the **Status** filter field are defined in the [Shipment workflow](../../../../developer/commerce/shipping_management/configure_shipment/index.md#configure-shipment-workflow).

To view shipment status:

1. In the left panel, go to **Commerce** -> **Shipments**.

2. Narrow down the list of displayed shipments in one of the following ways:

- search for shipments by typing part of order ID or identifier in the search box
- filter shipments by selecting one or more filters

## Filter shipments in shipment list

You can use filters to narrow down the list of shipments.

Available filters are:

- Shipping method - method used for the shipment
- Status - shipment status
- Created - a range of dates between which the shipment was created
- Updated - a range of dates between which shipment status has last changed

![Shipment filters](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/shipment_filters.png)

To filter the list, set one of the filters and click `Apply` button.

You can also clear all chosen filters - to do it, click `Clear filters`.

## View shipment details

To view the details of a shipment, click its line in the shipment list.

On the shipment details screen, you can see an overview of the shipment's details.

Shipment details include basic information about the shipment, customer details, shipping address, total value, order ID, and the date of the last update.

![Shipment detail view](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/shipment_detail_view.png)

## Change shipment status

If your [user role](../../../permission_management/work_with_permissions/index.md) has the `Shipment/Edit` permission, you can change the status of an existing shipment:

- "Pending" -> "Ready to ship" - click **Prepare** button, then click **Change** to confirm.
- "Ready to ship" -> "Shipped" - click **Send** button, then click **Change** to confirm.
- "Shipped" -> "Delivered" - click **Deliver** button, then click **Change** to confirm.
