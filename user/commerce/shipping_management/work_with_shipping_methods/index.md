# Work with shipping methods

Define new shipping methods or modify existing ones.

Editions: Commerce

If your [user role](../../../permission_management/work_with_permissions/index.md) includes the `Shipping method/Create` permission, you can create shipping methods. With the `Shipping method/Edit` permission, you can modify existing ones.

Shipping methods describe how goods can be shipped to a store customer, with different rates for different geographic locations. Example shipping methods are overnight delivery, self-pickup, or DHL.

> **Note: Shipping method limitations**
>
> By default, you can only create shipping methods of 'Flat rate' and 'Free shipping' type.
>
> Shipping methods created in legacy Commerce cannot be migrated when you upgrade. You have to define them from scratch.

"Flat rate" shipping means delivering goods at a fixed, predefined cost, regardless of the number, and type of items in the cart.

## Create new shipping method

1. In the left panel, go to **Commerce** -> **Shipping methods**, and click **Create**.

2. Select the language for the new shipping method, its type, and region that it applies to.

3. In the next screen provide information about the new shipping method.

![Creating a new shipping method](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/create_new_shipping_method.png)

Details about shipping cost differ between shipping methods:

- Flat rate requires setting a specific fixed cost for shipping, expressed as net value in a given currency. This value is then displayed during checkout and added to the total order amount when the store customer selects a specific shipping method.
- Free shipping requires setting the minimum order value (in a given currency) above which the shipping is free.

![Configuring free shipping](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/free_shipping.png)

4. Toggle the **Availability** switch on, so that store customers can select this shipping method during checkout.

5. Click **Create** to save your changes.

## Edit existing shipping method

1. In the left panel, go to **Commerce** -> **Shipping methods**.

![Shipping methods list](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/shipping_methods_list.png)

2. Use the search field and filters to find the shipping method that you intend to edit or delete.

3. Click the **Edit** button next to the method in the list.

4. Edit the necessary details.

5. Click **Update** to save your changes.

## Delete existing shipping method

1. In the left panel, go to **Commerce** -> **Shipping methods**.

2. Use the search field and filters to find the shipping method that you want to delete.

3. Select a box next to its name and click **Delete**.

> **Note: Shipping methods for existing orders**
>
> You cannot delete a shipping method if it's active or if it's used by open orders. You must first deactivate the method that you want to delete by toggling the **Availability** switch off.

## Filter shipping methods

1. In the left panel, go to **Commerce** -> **Shipping methods**.

2. Narrow down the list of displayed shipping methods in one of the following ways:

   - search for shipping method by typing part of its name or identifier in the search box
   - filter shipping methods by selecting one or more filters

   Available filters are:

   - Method type - method of the shipping
   - Availability - shipping method availability: Active, Inactive
   - Region - region that the shipping method applies to

3. Click **Apply** to confirm.
