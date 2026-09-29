# Create product types

Build new product types or modify existing ones.

If your [user role](../../permission_management/work_with_permissions/index.md) has the `ProductType/Edit` permission, you can modify product types and add individual attributes or attribute groups.

> **Note: Quable PIM integration**
>
> When [Quable is configured as the source of product information](../quable_pim_integration/index.md), product types are defined in Quable and cannot be created or modified in Ibexa DXP. Manage product types in the Quable back office instead.

1. In the left panel, go to **Product catalog** -> **Product Types** and click **Create**.

![Create new product type](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/create_new_product_type.png "Create new product type")

2. From the drop-down list choose "Physical" or "Virtual" type and click **Add**.

![Selecting a type of product type](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/virtual_product_type.png "Selecting a type of product type")

3. Fill in basic product information: name, identifier and description.

![Defining product type settings](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/create_product_type.png "Defining product type settings")

Each product has a product code that must be unique. It identifies the product in the system. Product code can have up to 64 characters. It can contain only letters, numbers, underscores, and dashes.

4. Add fields that describe the product by dragging them from the **Field types** area to the **Field definitions** section, and then [configure them](../../content_management/configure_ct_field_settings/index.md).

For the information that is intended to be displayed, use [TextLine](../../../developer/content_management/field_types/field_type_reference/textlinefield/index.md) fields for short text, and [RichText](../../../developer/content_management/field_types/field_type_reference/richtextfield/index.md) fields for longer text that may require formatting.

5. Add attributes by dragging them or their groups from the **Library** area to the **Attributes** section.

Use attributes to store precise lists of product properties or specifications.

When you define attributes for the product type, you can add or remove either whole attribute groups or individual attributes.

![Adding attributes to a product type](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/adding_attributes.png "Adding attributes to a product type")

You can also remove whole groups, or single attributes from groups that you don't want to use for the given product type. Do this by clicking the **X** icon next to the group or attribute.

For every attribute, you can select **Used for product variants**. Attributes that have this option are used to [automatically generate product variants](../work_with_product_variants/index.md#generate-variants).

6. Below the **Attributes** section, in the **VAT rates** area, assign VAT rates that apply to all products of this type.

![Assigning VAT rates](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/vat_rates_product_type.png "Assigning VAT rates")

> **Tip: Tip**
>
> When your website supports multiple regions, you can use the search field to find the right one.
