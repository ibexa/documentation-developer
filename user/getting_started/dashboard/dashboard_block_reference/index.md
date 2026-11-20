# Dashboard block reference

Pick from a list of dynamic blocks to create a customized dashboard.

The following blocks are provided with a clean installation of Ibexa DXP:

| Block                                                     | Description                                                                                                                 |
| --------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------- |
| [Common content](#common-content-block)                   | Displays a list of content items created by all members of the organization that the user belongs to.                       |
| [Ibexa News](#ibexa-news-block)                           | Displays a list of recent blog posts or articles published at [ibexa.co blog](https://www.ibexa.co/blog) (product related). |
| [My content](#my-content-block)                           | Displays a list of content items created by the user who is currently logged in.                                            |
| [Orders by status](#orders-by-status-block)               | Displays a chart presenting orders and their status.                                                                        |
| [Products by category](#products-by-category-block)       | Displays a chart presenting products by their category.                                                                     |
| [Products with lowest stock](#products-by-category-block) | Displays a table presenting products with the lowest stock.                                                                 |
| [Quick actions](#quick-actions-block)                     | Displays selected mostly used actions and shortcuts.                                                                        |
| [Recent activity](#recent-activity-block)                 | Displays a list of recent activity of all or selected users.                                                                |
| [Recent orders](#recent-orders-block)                     | Displays a table presenting recent orders and their status.                                                                 |
| [Review queue](#review-queue-block)                       | Displays a list of content items which user or user group can review.                                                       |

> **Note: Note**
>
> Before you add a block that involves products, product types, or product categories, make sure your that your [user role](../../../permission_management/permissions_and_users/index.md) has the `Product/View` and `Product type/View` permission.

## Common content block

Displays a list of content items created by all members of the organization that the user belongs to. It shows the following tabs: **Content**, **Scheduled**, **Media**.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of content and submit your changes.

## Ibexa News block (Experience, Commerce)

Presents a list of recent blog posts or articles published at `ibexa.co` blog (product related). It includes title, image, publication date, and link to article details.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.
- **Number of news** - Set a maximum number of news to be displayed. Default = 7, minimum value = 1, and maximum = 10.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of news and submit your changes.

## My content block

Displays a list of content items created by the user who is currently logged in. It shows the following tabs: **Drafts**, **My shared drafts**, **Drafts shared with me**, **Scheduled**, **Content**, **Media**, **Drafts to review**.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of content and submit your changes.

## Orders by status block (Commerce)

Displays a chart presenting orders split by status, with their number and percentage.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.
- **Statuses** - Set the statuses of orders that should be included in the list. Default value = All. The list of statuses depends on configured [order workflow](../../../../developer/commerce/order_management/configure_order_management/index.md) and can be customized.
- **Time period** - Set the time period: All time, Last day, Last week, Last month. Default value = Last month.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of orders and submit your changes.

## Products by category block (Experience, Commerce)

Displays a chart presenting the products split by category, together with the percentage.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.
- **Number of categories** - Set a maximum number of categories to be displayed. Default value = 10.
- **Show uncategorized products** - If selected, displays uncategorized products in the chart.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of products and submit your changes.

This block is not supported when using [Quable](../../../product_catalog/quable_pim_integration/index.md) as the source of product information.

## Products with lowest stock block (Experience, Commerce)

Displays a table of products with the lowest stock. Products are sorted based on Stock value (sorted from lowest to highest stock).

The table contains the following columns: Name, Image, Code, Category, Type, Variant, Stock.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.
- **Number of visible products** - Set a number of products to be displayed. Default value = 10, minimum value = 1, and maximum = 10.
- **Stock threshold** - Set up the maximum stock value (only products with stock number greater than zero and less than the set maximum number are displayed). Default value = 10.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of products and submit your changes.

This block is not supported when using [Quable](../../../product_catalog/quable_pim_integration/index.md) as the source of product information.

## Quick actions block (Experience, Commerce)

Displays selected mostly used actions and shortcuts, for example, **Create content**.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.
- **Actions** - Select actions to be displayed as shortucts: Create content, Create form, Create product, Create catalog, Create company. Default value = All.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of quick actions and submit your changes.

## Recent activity block (Experience, Commerce)

Displays a list of recent activity of all or selected users. It also includes a link to view all activities available in Admin tab.

Recent activity block contains the following data:

- action time
- user reference (avatar, first and last name) with a link to the user profile (if available)
- activity type with the context

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.
- **Users** - Select users whose recent actions should be visible. By default, activities of all users are configured.
- **Activity area** - Choose an activity area to be displayed. Default value = All.
- **Number of activities** - Set a maximum number of activity logs to be displayed. Minimum value = 1, and maximum = 10.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of content items for review and submit your changes.

## Recent orders block (Commerce)

Displays a table presenting recent orders with the newest creation date/recently placed.

Table contains following columns: Order ID, Company name, Customer name, Unique items, Total value, Status, Created.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.
- **Statuses** - Set the statuses of orders that should be included in the list: Pending, Processing, Cancelled, Completed. Default value = All.
- **Number of orders** - Set a maximum number of orders to be displayed. Default value = 10.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of orders and submit your changes.

## Review queue block

Displays a list of content items which user or user group can review.

On the **Properties** tab, set values in the following fields:

- **Name** - Enter a name for the block.

On the **Design** tab, in the **View** field, select the layout to be used to present a list of content items for review and submit your changes.
