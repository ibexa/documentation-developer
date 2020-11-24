# Variants in eContent [[% include 'snippets/commerce_badge.md' %]]

`ses_variants` can be used to store variant data for a product. 

The variants must be stored in a JSON format.
For more information, see [Product Variants](../../../guide/catalog/product_variants/product_variants.md).

``` json
[
  {
    "sku": {
      "label": "Sku",
      "value": "0002"
    },
    "variantCode": {
      "label": "Variant Code",
      "value": "D4142"
    },
    "description": {
      "label": "Description",
      "value": "Bubble light bulb small"
    },
    "characteristicCode1": {
      "label": "small",
      "value": "small"
    },
    "characteristicLabel1": {
      "label": "Color",
      "value": "Color"
    },
    "characteristicCode2": {
      "label": "Silver",
      "value": "Silver"
    },
    "characteristicLabel2": {
      "label": "",
      "value": ""
    },
    "priceNet": {
      "label": "Listprice net",
      "value": "220"
    },
    "vatPercent": {
      "label": "VAT percent",
      "value": ""
    },
    "dataMap_countryOfOrigin": {
      "label": "dataMap Country of Origin",
      "value": ""
    }
  },
  {
    "sku": {
      "label": "Sku",
      "value": "0002"
    },
    "variantCode": {
      "label": "Variant Code",
      "value": "D4143"
    },
    "description": {
      "label": "Description",
      "value": "Bubble light bulb large"
    },
    "characteristicCode1": {
      "label": "large",
      "value": "large"
    },
    "characteristicLabel1": {
      "label": "Size",
      "value": "Size"
    },
    "characteristicCode2": {
      "label": "Silver",
      "value": "Silver"
    },
    "characteristicLabel2": {
      "label": "Color",
      "value": "Color"
    },
    "priceNet": {
      "label": "Listprice net",
      "value": "220"
    },
    "vatPercent": {
      "label": "VAT percent",
      "value": ""
    },
    "dataMap_countryOfOrigin": {
      "label": "dataMap Country of Origin",
      "value": ""
    }
  },
  {
    "sku": {
      "label": "Sku",
      "value": "0002"
    },
    "variantCode": {
      "label": "Variant Code",
      "value": "5532"
    },
    "description": {
      "label": "Description",
      "value": "Alibaba Single Door Silver Refrigerator"
    },
    "characteristicCode1": {
      "label": 30,
      "value": 30
    },
    "characteristicLabel1": {
      "label": "Size",
      "value": "Size"
    },
    "characteristicCode2": {
      "label": "White",
      "value": "White"
    },
    "characteristicLabel2": {
      "label": "Color",
      "value": "Color"
    },
    "priceNet": {
      "label": "Listprice net",
      "value": "330"
    },
    "vatPercent": {
      "label": "VAT percent",
      "value": ""
    },
    "dataMap_countryOfOrigin": {
      "label": "dataMap Country of Origin",
      "value": ""
    }
  }
]
```
