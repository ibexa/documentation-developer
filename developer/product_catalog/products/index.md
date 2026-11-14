# Products

Products are characterized by attributes describing their characteristics. You can create product variants and add assets to each product and variant.

Products are a special type of content that contains typical content Fields and additional product information.

Each product belongs to a product type (similar to how a content item belongs to a content type).

Each product has a unique identifying product code. Product code can have up to 64 characters. It can contain only letters, numbers, underscores, and dashes.

## Product types

Product types represent categories that a product can belong to. A product type can be, for example, a sofa, or a keyboard.

Product types, like content types, define the global properties of products and fields a product consists of. A product type also defines the attributes that all products of this type can have.

You can choose between two available types: `physical` and `virtual`:

- `physical` - tangible products with assigned stock. They can use measurement attributes. They require shipment in the online purchase process. Examples: heaters, laptops, phones.
- `virtual` - non-tangible items. They can be sold individually, or as part of a product bundle. They don't require shipment in the online process. Examples: memberships, services, warranties.

## Product attributes

Product attributes provide different information about a product and can be used to create [product variants](#product-variants). Typical product attribute examples are: length, weight, color, format, and more.

The following attribute types are available:

| Name                                                                                            | Identifier  | Description                                                                                      |
| ----------------------------------------------------------------------------------------------- | ----------- | ------------------------------------------------------------------------------------------------ |
| Checkbox                                                                                        | `checkbox`  | Boolean attribute with a true/false value.                                                       |
| Color                                                                                           | `color`     | Color value stored as a hex code.                                                                |
| [Date and time](../attributes/date_and_time/index.md)  | `datetime`  | Date and time value with configurable accuracy levels.                                           |
| Float                                                                                           | `float`     | Decimal number value.                                                                            |
| Integer                                                                                         | `integer`   | Integer number value.                                                                            |
| Selection                                                                                       | `selection` | A value selected from a predefined list of labeled options.                                      |
| [Symbol](../attributes/symbol_attribute_type/index.md) | `symbol`    | String value with an enforced format, suitable for standardized identifiers such as EAN or ISBN. |

Product attributes are collected in groups. An example of an attribute group can be dimensions (length, width, height).

You can assign both whole attribute groups or individual attributes to a product type.

> **Note: Attribute translations**
>
> Product attributes are not translatable. Unlike content fields, product attribute values cannot differ between languages.
>
> For the information that is intended to be displayed, consider using [TextLine](../../content_management/field_types/field_type_reference/textlinefield/index.md) fields for short text, [RichText](../../content_management/field_types/field_type_reference/richtextfield/index.md) fields for longer text that may require formatting, and product attributes for precise product properties or specifications.

## Product variants

Product variants represent different versions of a product, for example, clothes in different colors, or laptops with different amounts of RAM.

You can create product variants automatically based on attributes that have the "Used for product variants" flag enabled in the product type definition.

You can create variants for any combination of values of selected attributes. In the back office you can automatically generate all possible variants for a product.

Codes for product variants are generated automatically based on the [selected strategy](../product_catalog_configuration/index.md#code-generation-strategy).

Each product variant has separate availability and stock information. Each variant can also have separate price rules. If a variant doesn't have separate price rules, it uses the price of its base product.

## Product assets

Product assets are images that are assigned to products and their specific variants.

You can group assets in collections which correspond to specific values of attributes. A collection is assigned to the variant or variants that have these attribute values.

## Embed products in content

You can embed products directly into content, including the [landing pages](../../content_management/pages/pages/index.md), by using the [Online Editor](../../content_management/rich_text/online_editor_guide/index.md).

Use it to build marketing campaigns directly around the products, bridging product marketing and product data together.

To customize the design of the embedded products, see [Customize product embed templates](../customize_product_embed_templates/index.md).

## Product availability and stock

Product availability defines whether a product is available in the catalog.

You set product availability per variant or per base product:

- if a product cannot have variants (has no attributes with the "Used for product variants" flag), you set availability per base product
- if a product can have variants (even if no variants are configured yet), you set availability per variant.

When a product is set as available, it can have numerical stock defined. The stock can also be set to infinite (for example, in case of digital products).

### Availability and computed availability

Setting a product as available doesn't automatically mean that it can be ordered. For example, a product can be set as available, but have zero stock.

The product catalog distinguishes between two types of availability:

- Availability as a value set per product or variant

  Availability represents whether the product was set as **Available**, for example in the [back office **Availability** tab](../../../user/product_catalog/manage_availability_and_stock/index.md#set-product-availability) or [PHP API](../product_api/index.md#product-availability).

- Computed availability

  Computed availability represents whether the product can actually be ordered. By default, a product can only be ordered when it's set as available and has either positive or infinite stock.

You can implement a custom strategy to handle different selling scenarios, such as minimum order quantity, minimum stock quantity, or region-specific availability. For more information, see [Create custom availability strategy](../create_custom_availability_strategy/index.md).
