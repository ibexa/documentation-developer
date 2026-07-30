# Products

Products are containers that aggregate information about the items you offer, for example, their specs, variants, or availability.

Products are instances of a particular [product type](../product_types/index.md). A product is an object that's based on a product type template. It can have [variants](../work_with_product_variants/index.md) that you build around [attributes](../work_with_product_attributes/index.md). Products can be put in [catalogs](../work_with_catalogs/index.md) and organized into [categories](../work_with_product_categories/index.md).

For each product and product variant, you can define its [availability](../manage_availability_and_stock/index.md), stock and [prices](../manage_prices/index.md).

When you create or edit products, you can add [assets](../work_with_product_assets/index.md) in a form of images. Assets can be assigned to the base product, and to one or more of its variants.

Products can also be [embedded in content items](../../content_management/create_edit_content_items/index.md#embed-products) and [landing pages](../../content_management/block_reference/index.md#product-embed) to showcase them within editorial content, such as articles and landing pages.

> **Note: Quable PIM integration**
>
> When [Quable is configured as the source of product information](../quable_pim_integration/index.md), creating and editing products in Ibexa DXP is not available.
>
> Product data is managed in the Quable back office, with the exception of [managing prices](../manage_prices/index.md) and [availability](../manage_availability_and_stock/index.md) which happen in Ibexa DXP. In addition, you can use Ibexa DXP to browse, search, filter, and embed Quable products in content items, including landing pages.

For more information about creating products, see [Create product](../create_edit_product/index.md#create-and-edit-products).

## Product completeness

Before your customers can purchase products, the website [administrator must configure](../../../developer/product_catalog/enable_purchasing_products/index.md) at least one region and one currency for the shop, and VAT rates for each of the regions. You must then set:

- VAT rates for the product type
- at least one price for the product
- availability with positive or infinite stock for the product

When you review product details, under the product name, you can see a progress bar with an approximate indication of how much of the product information you provided, and how much is still missing.

![Quick view of product completeness](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/product_completeness_bar.png "Quick view of product completeness")

To find out in detail, which pieces of product information require your attention, go to the product view's **Completeness** tab. It lists all tasks required for product configuration, including:

- content (such as images and descriptions)
- attributes
- assets
- variants (if any of the attributes is enabled for variants)
- availability
- prices in different currencies
- translations

![Product completeness screen](https://doc.ibexa.co/projects/userguide/en/5.0/product_catalog/img/product_completeness.png "Product completeness screen")

You can click the **Edit** button next to an unfinished task in the **Completeness** table to go directly to the screen where you can add the missing information.

> **Note: Impact on availability**
>
> Product completeness does not impact product availability or visibility on the storefront. It is intended to help you ensure that product data is properly populated. As long as your product meets the pricing and stock requirements, it can be published and made available for purchase regardless of its completeness score.
