---
edition: headless
month_change: true
---

# Product specification field type

This field represents and handles [product attributes](products.md#product-attributes) and [VAT](prices.md#vat).
Consider it as internal to the [PIM](pim.md).

| Name                   | Internal name                 | Expected input |
|------------------------|-------------------------------|----------------|
| `ProductSpecification` | `ibexa_product_specification` | mixed          |

!!! caution

    The presence of a specification (`ibexa_product_specification`) field distincts product types from content types.
    Don't remove this field from a product type (or it becomes a unreachable hidden content type).
    Don't add such field to a content type (or it becomes an uneditable unusable product type).
