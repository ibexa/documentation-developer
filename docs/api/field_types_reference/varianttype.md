# VariantType

The VariantType Field Type offers a user interface for editing [product variants](../../guide/catalog/product_variants/product_variants.md).

The Field Type offers a selection of preconfigured variant types.

A variant type can be a one level or two level variant.
The variant types can be [set up in a YAML file](../../guide/catalog/product_variants/product_variants.md#adding-new-variants).

The data is stored in JSON format:

``` json
[
  {
    "sku": {
      "label": "Sku",
      "value": "5515"
    },
    "variantCode": {
      "label": "Variant Code",
      "value": "5515"
    },
    "description": {
      "label": "Description",
      "value": "Alibaba Single Door Silver Refrigerator"
    },
    // ...
  },
]
```
