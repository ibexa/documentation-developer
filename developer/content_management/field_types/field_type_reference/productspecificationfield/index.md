# Product specification field type

Editions: Headless

This field represents and handles [product attributes](../../../../product_catalog/products/index.md#product-attributes) and [VAT](../../../../product_catalog/prices/index.md#vat). Consider it as internal to the [product catalog](../../../../product_catalog/product_catalog/index.md).

| Name                   | Internal name                 | Expected input |
| ---------------------- | ----------------------------- | -------------- |
| `ProductSpecification` | `ibexa_product_specification` | mixed          |

> **Caution: Caution**
>
> The presence of a specification (`ibexa_product_specification`) field distincts product types from content types. Don't remove this field from a product type (or it becomes a unreachable hidden content type). Don't add such field to a content type (or it becomes an uneditable unusable product type).
