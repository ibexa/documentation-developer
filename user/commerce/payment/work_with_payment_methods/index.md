# Work with payment methods

Define new payment methods or modify existing ones.

Editions: Commerce

If your [user role](../../../permission_management/work_with_permissions/index.md) has the `Payment method/Create` permission, you can create payment methods. With the `Payment method/Edit` permission, you can modify existing ones.

Payment methods describe the way store customers pay for their orders during the checkout process.

> **Note: Payment method limitations**
>
> By default, you can only create payment methods of `Offline` type. If your organization needs other payment method types, contact your administrator or development team about [creating a custom payment method type](../../../../developer/commerce/payment/extend_payment/index.md#define-custom-payment-method-type).
>
> Payment methods created in legacy Commerce cannot be migrated when you upgrade. You have to define them from scratch.

## Create new payment method

1. In the left panel, go to **Commerce** -> **Payment methods**, and click **Create**.

2. Select the language for the new payment method and its type.

![New payment method](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/new_payment_method.png)

3. In the next screen provide information about the new payment method.

![Creating a new payment method](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/create_new_payment_method.png)

4. Toggle the **Availability** switch on, so that store customers can select this shipping method during checkout.

5. Click **Create** to save your changes.

## Edit existing payment method

1. In the left panel, go to **Commerce** -> **Payment methods**.

![Payment methods list](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/payment_methods_list.png)

2. Use the search field and filters to find the payment method that you want to edit.

3. Click the **Edit** button next to the method in the list.

4. Edit the necessary details.

5. Click **Update** to save your changes.

## Delete existing payment method

1. In the left panel, go to **Commerce** -> **Payment methods**.

2. Use the search field and filters to find the payment method that you want to delete.

3. Select a box next to its name and click **Delete**.

> **Note: Payment methods for existing orders**
>
> You cannot delete a payment method if it's active or if it's used by unpaid orders. You must first deactivate the method that you want to delete by toggling the **Availability** switch off.

## Filter payment methods

1. In the left panel, go to **Commerce** -> **Payment methods**.

2. Narrow down the list of displayed payment methods in one of the following ways:

   - search for payment method by typing part of its name or identifier in the search box
   - filter payment methods by selecting one or more filters

   Available filters are:

   - Method type - method of the payment
   - Availability - payment method availability: Active, Inactive

3. Click **Apply** to confirm.
