# Create and edit products

Create new products or modify existing ones.

[Products](../products/index.md#products) are a specific kind of [content items](../../content_management/content_items/index.md#content-items) that you use to present your offer in the website, including product specification, and pricing. Individual products are instances of [product types](../create_product_types/index.md#create-product-types). You can only create or modify products when your [user role](../../permission_management/work_with_permissions/index.md) has the `Product/Edit` permission.

> **Note: Quable PIM integration**
>
> When [Quable is configured as the source of product information](../quable_pim_integration/index.md), creating and editing products in Ibexa DXP is not available. Products are managed in the Quable back office and are automatically available in Ibexa DXP. You can still [manage prices](../manage_prices/index.md) and [availability](../manage_availability_and_stock/index.md) for Quable products in Ibexa DXP.

To create a product, depending on how the product type is defined, you [may need to provide](../products/index.md#product-completeness) certain pieces of information in their respective [fields](../../content_management/content_model/index.md#fields-and-field-types).

You can create products using either manual or bulk method. Bulk method can be used only at the developer level. See [Products](../../../developer/product_catalog/product_api/index.md#products) for a technical guide on how to do this.

1. Click **Product catalog** -> **Products**.

2. If you're adding a new product, click **Create** and skip to step 4.

3. If you're editing an existing product, in the **Category filter** tree, select a category to find your product more quickly. Then click the **Edit** button next to a name of the product item that you want to modify and skip to step 5.

![Products list with action buttons](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/edit_product.png "Products list with action buttons")

4. From their lists, select the language and the product type, and then click the **Add** button.

![Creating a new product](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/create_new_product.png "Creating a new product")

5. Fill in or edit content fields of the product, for example, name, specification, and description. Fields marked with an asterisk (\*) are required.

![Editing product information](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/create_product.png "Editing product information")

6. In the Attributes section, define the product's attributes, for example, dimensions, resolution, or capacity.

7. If you're adding a new product, click the **Create** button. If you're editing an existing one, click the **Update** button.

After you create a product, you can [add image assets to a product](../work_with_product_assets/index.md), [create variants to the main product](../work_with_product_variants/index.md), [define product prices](../manage_prices/index.md), [set the available quantity](../manage_availability_and_stock/index.md) and [classify products into different categories](../work_with_product_categories/index.md).

> **Note: Note**
>
> Feature availability may differ depending on the specifics of your installation.

For in-depth information, see [Products](../../../developer/product_catalog/products/index.md) in Developer Documentation.
