# Work with discounts

Create and edit discounts, toggle discount status.

Editions: Commerce

In Ibexa DXP, on the **Discounts** screen, you can either view a list of discounts, or update existing discounts and create new ones depending on permissions assigned to your [user role](../../../permission_management/work_with_permissions/index.md).

## View discount information in discounts list

1. In the left panel, go to **Commerce** -> **Discounts**.

   Here, you can see a list of discounts, together with information about their validity period, status, type, and their authors.

2. Narrow down the list of displayed discounts in one of the following ways:

   - search for a discount by typing in a part of its name or identifier in the search field
   - filter discounts by selecting one or more of the following filters:
     - **Discount type**: applicable to catalog or cart products
     - **Status**: active, inactive or disabled
     - **Created**: start and end of date range within which the discount was created
     - **Validity period**: start and end of date range within which the discount is in force

   ![Discount filters](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discount_filters.png)

3. Click **Apply** to confirm your choices.

4. To clear all the filters, click **Clear filters**.

### Instantly disable discount

When working with discounts it may happen that a discount has been created or enabled in error and you notice that it has negative impact on your business.

To disable the offending discount, find it in the discount list and, in its line, click the **Disable** icon.

![Discount filters](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discount_disable_icon.png)

### View discount details

To view the details of a discount, click its line in the discount list. On the discount details screen, you can see an overview of the discount's details.

Discount details include basic information about the discount:

- validity period and value of the discount
- region and currency that the discount applies to
- whether the discount applies to all customers or a selected customer group,
- whether any conditions apply

![Discount detail view](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discount_detail_view.png)

On other tabs within this screen you can see:

- products subject to the discount
- users who have authored or modified the discount
- translations created for the discount

### Add translations

If your store supports multiple languages and you want different discount names and/or descriptions to appear to customers from different markets, while [viewing discount details](#view-discount-details), you can go to the **Translations** tab and [add translations](../../../content_management/translate_content/index.md#add-translations).

## Create new discount

When you create discounts, you must first decide whether they apply to all [products](../../../product_catalog/products/index.md) from the catalog, or the products that the customer has put into their cart. You are then taken through a series of steps, where you define the discount, for example, decide if it applies to selected [customer groups](../../../../developer/users/customer_groups/index.md) and specific products. Cart discount applicability can be further limited by setting a number of conditions, such as:

- a number of products in the cart
- total purchase value
- a discount code

> **Note: Navigating through the steps**
>
> When you define discount details, you can go back to change your choices. To do it, click a step header at the top of the screen.
>
> ![Discount creator steps](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discount_creator_headers.png)

1. In the left panel, go to **Commerce** -> **Discounts**, and click **Create**.

2. Select whether the discount applies to catalog or cart products and the discount's type.

   Choose **Fixed amount** to deduct a specific amount of money from the base price of the product, or **Percentage** to calculate the deducted amount based on a specific percent value.

   ![New discount](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/new_discount.png)

3. In the **General properties** screen, provide general information about the new discount:

   1. In the **Global properties** area, provide an internal name of the discount and set the validity period. Toggle the **Permanent discount** on to make the discount valid until you manually disable it.

   2. Then, select discount priority to help the system choose between discounts to apply when calculating the final price.

      > **Note: Only one discount at a time**
      >
      > When two or more discounts could be applied to the base price of the product, the system uses only one, based on a number of rules. For example, cart discounts surpass catalog discounts.
      >
      > For more information, see [the product guide](../../../../developer/discounts/discounts_guide/index.md#discounts-priority).

   3. If your store supports multiple markets, you can select a region that the discount applies to.

   4. If you are creating a fixed-amount discount, select a currency of the discount.

   ![Creating a new discount](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/create_new_discount.png)

   1. In the **Promotion information** area, provide a name and description of the promotional campaign, as they should be shown to customers.

   ![Adding information about the promotion](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discounts_promo_info.png)

   1. Click **Next** to go to the next screen.

4. In the **Target group** screen, select customers that the new discount is targeted at. You can choose everyone, or select one or more customer groups.

   ![Customer selection](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discounts_select_customers.png)

5. In the **Products** screen, select products that the discount applies to. You can choose between:

   - all products from the catalog, for example, to clear stock before the end of year
   - products from a specific category, for example, promotional gadgets for company partners
   - specific products or even product variants, to activate slow-moving inventory

   In the latter case, you select products by using a Product picker, where you can use search and filters to pinpoint the exact product or product variant that you want the discount to apply to.

   ![Product picker](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/product_picker.png)

6. If you are creating a cart discount, in the **Conditions** screen, you can set the conditions that limit the discount's availability to customers who have:

   - added to cart no less than a specific number of certain items
   - added products to a cart for no less than a specified total value
   - entered a specified discount code

   If you set the discount code, you can set the number of times that the code can be used:

   - by a certain customer
   - in total, by all customers

   ![Cart discount conditions](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/cart_discount_conditions.png)

7. In the **Discount value** screen, if you are creating a percentage-based discount, in **Customer gets discount value**, enter a percent value that the system uses to calculate the amount deducted from the base price of the product. Otherwise, enter a monetary value to be deducted from the base price.

8. In the **Summary** screen, review the details of the discount that you are creating, and click **Save and close** to save the discount. Depending on the settings, you may see a warning message.

   ![Discount summary screen notice](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discounts_summary_notice.png)

## Edit existing discount

You may find that an existing discount needs to be modified, for example, to change its validity period or target group.

1. In the left panel, go to **Commerce** -> **Discounts**.

   ![Discounts list](https://doc.ibexa.co/projects/userguide/en/5.0/commerce/img/discount_list.png)

2. Use the search field and filters to find the discount that you want to edit.

3. Click the **Edit** button next to the discount in the list.

4. Edit the necessary details as described in [Create new discount](#create-new-discount).

5. **Save and close** to save your changes.

## Delete existing discount

When there are too many discounts in the system, you may want to delete historic, unused ones. You can only delete disabled discounts.

1. In the left panel, go to **Commerce** -> **Discounts**.
2. Use the search field and filters to find the discount that you want to delete.
3. If the discount that you want to delete is not disabled, use the **Disable** icon to [disable it](#instantly-disable-discount).
4. Select a box next to the discount's name and click **Delete**.
