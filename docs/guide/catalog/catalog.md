# Product catalog

The product catalog enables handling of products offered in the shop,
including their specifications, product variants, and pricing.

## Products

Products are a special type of content that contains typical content Fields
as well as additional product information.

Each product belongs to a product type (similar to how a Content item belongs to a Content Type).

## Product types

Product types represent categories that a product can belong to.
A product type can be, for example, a sofa or a keyboard.

Product types, like Content Types, define the global properties of products and Fields a product consists of.
A product type also defines the attributes that all products of this type can have.

## Product attributes

Product attributes provide different information about a product.
Typical product attribute examples are: length, weight, color, format, and so on.

The following attribute types are available:

- Checkbox
- Float
- Integer
- Selection

Product attributes are collected in groups.
An example of an attribute group can be dimensions (length, width, height).

You can assign both whole attribute groups or individual attributes to a product type.

## Product variants

Product variants are different versions of a single product that differ in some attributes.

Example products with variants can be: sofas in different colors or laptops with different hard drive sizes.

When defining attributes for a product type, you can select which attributes can be the basis for creating product variants.

For example, a sofa product type can have multiple attributes: length, width, height, and so on.
It can also have another attribute that distinguishes variants: color.
If you enable the attributes to be used for product variants, variants of the product can correspond to the different colors.

A product type can have multiple attributes that create variants.
In that case, you can create variants based on the combination of all the attributes.
The product catalog can automatically generate variants based on all selected attributes.
You can aso manually select which generated variants you want to disable.
