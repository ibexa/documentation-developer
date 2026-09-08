---
description: Create a symbol attribute type that enables for the efficient representation of string-based values while enforcing their format in product specifications.
---

# Symbol attribute type

In product specifications, the symbol attribute type enables the efficient representation of string-based data and enforces their format.

This feature allows you to store standard product identifiers (such as EAN or ISBN) in the [product catalog](product_catalog_guide.md).

## Build-in symbol attribute formats

The built-in symbol attribute formats in `ibexa/product-catalog-symbol-attribute` are listed below:

| Name | Description | Example |
|-----------------|-----------------|-----------------|
| Generic | Accepts any string value  | #FR1.2 |
| Generic (alphabetic characters only) | Accepts any string value that contains only letters  | ABCD |
| Generic (digits only) | Accepts any string value that contains only digits  | 123456 |
| Generic (alphanumeric characters only) | Accepts any string value that contains only letters or digits | 2N6405G |
| Generic (hexadecimal digits only) | Accepts any string value that contains only hexadecimal digits (digits or A-F characters) | DEADBEEF |
| EAN-8 | European Article Number (8 characters)  | 96385074 |
| EAN-13 | European Article Number (13 characters)  | 5023920187205 |
| EAN-14 | European Article Number (14 characters)   | 12345678901231 |
| ISBN-10 | International Standard Book Number (10 characters)  | 0-19-852663-6 |
| ISBN-13 | International Standard Book Number (13 characters)  | 978-1-86197-876-9 |

!!! caution

    Maximum length of the symbol value is 160 characters.

## Search for products with given symbol attribute

You can use `SymbolAttribute` Search Criterion to find products by symbol attribute:

For more information, see [SymbolAttribute Criterion](symbolattribute_criterion.md).
