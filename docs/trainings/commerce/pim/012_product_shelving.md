---
description: "PIM training: Product shelving"
edition: experience
page_type: training
---

# Product shelving

There is several ways to group and sort products. TODO

## Catalogs

[Catalogs](catalogs.md) group products by filtering on product data.

TODO: What having several catalogs implies (navigation, customer experience,…)
TODO: How catalogs are displayed? Move this concern to "Product displaying"
TODO: [Create custom catalog](create_custom_catalog_filter.md)

## Categories

Product categories are tags in the `product_categories` [taxonomy](taxonomy.md).

If you're curious, you can find the `product_categories` taxonomy configuration in `vendor/ibexa/product-catalog/src/bundle/Resources/config/prepend.yaml`.

Exercise:

- Create a "Bike" category, its child "Mountain Bike" category, with for the latter two children categories "4 Series" and "5 Series"
- Categorize the products from previous chapter's exercise into the right series:

- Bike
    - Mountain Bike
        - 4 Series
            - Fuji
            - Matterhorn
            - Annapurna
            - Etna
        - 5 Series
            - Kilimanjaro
            - Stádda
            - Aconcagua
            - Ventoux
            - Castor
