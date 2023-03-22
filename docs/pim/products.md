---
description: Products in the PIM are characterized by attributes describing their characteristics. You can create product variants and add assets to each product and variant.
---

# Products

Products are a special type of content that contains typical content Fields
as well as additional product information.

Each product belongs to a product type (similar to how a Content item belongs to a Content Type).

Each product has a unique identifying product code.
Product code can have up to 64 characters. It can contain only letters, numbers, underscores, and dashes.

## Product types

Product types represent categories that a product can belong to.
A product type can be, for example, a sofa or a keyboard.

Product types, like Content Types, define the global properties of products and Fields a product consists of.
A product type also defines the attributes that all products of this type can have.

## Product attributes

Product attributes provide different information about a product
and can be used to create [product variants](#product-variants).
Typical product attribute examples are: length, weight, color, format, and so on.

The following attribute types are available:

- Checkbox
- Color
- Float
- Integer
- Measurement
- Selection

Product attributes are collected in groups.
An example of an attribute group can be dimensions (length, width, height).

You can assign both whole attribute groups or individual attributes to a product type.

## Product variants

Product variants represent different versions of a product, for example, clothes in different colors,
or laptops with different amounts of RAM.

You can create product variants automatically based on attributes
that have the "Used for product variants" flag enabled in the product type definition.

You can create variants for any combination of values of selected attributes.
In the Back Office you can automatically generate all possible variants for a product.

Codes for product variants are generated automatically based on the [selected strategy](pim_configuration.md#code-generation-strategy).

Each product variant has separate availability and stock information.
Each variant can also have separate price rules.
If a variant does not have separate price rules, it uses the price of its base product.

## Product assets

Product assets are images that are assigned to products and their specific variants.

You can group assets in collections which correspond to specific values of attributes.
A collection is assigned to the variant or variants that have these attribute values.

## Product availability and stock

Product availability defines whether a product is available in the catalog.

You set product availability per variant or per base product:

- if a product cannot have variants (has no attributes with the "Used for product variants" flag), you set availability per base product
- if a product can have variants (even if no variants are configured yet), you set availability per variant.

When a product is available, it can have numerical stock defined.
The stock can also be set to infinite (for example, in case of digital products).

!!! note

    Availability does not automatically mean that a product can be ordered.
    A product can be available, but have zero stock.

    A product can only be ordered when it has either positive stock, or stock set to infinite.

