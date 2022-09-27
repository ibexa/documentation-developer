---
description: Configure the setup of the quick order functionality for quickly ordering products in bulk.
edition: commerce
---

# Quick order configuration

## Disabling autosuggestion

To disable autosuggestions in quick orders, use the `auto_suggest_limit` setting:

``` yaml
ibexa_commerce_search.default.search.auto_suggest_limit: 0
```

## Variant delimiters

You can configure delimiters used between the SKU and variant code in the quick order form.

`sku_variant_code_delimiter` defines the delimiter used when displaying autosuggestion results:

``` yaml
parameters:
    ibexa.commerce.site_access.config.quick_order.default.sku_variant_code_delimiter: '::'
```

`autosuggest_delimiters` defines the delimiters that the customer can use when typing into the quick order form field:

``` yaml
parameters:
    ibexa.commerce.site_access.config.quick_order.default.autosuggest_delimiters: [' ', '/', '-', '::']
```

!!! caution

    The configured delimiter cannot be a part of the existing SKUs or variant codes.

### CSV delimiters

The values in CSV files can by separated by a configurable delimiter:

``` yaml
parameters:
    ibexa.commerce.site_access.config.quick_order.default.csv_delimiters: [';', ',']
```

## CSV data order

You can configure the order in which data can be provided in CSV format in the following way:

``` yaml
parameters:
    ibexa.commerce.site_access.config.quick_order.default.csv_data:
        - sku
        - variantCode
        - quantity
        - customText
```

## Solr fields for autosuggestion

Autosuggest uses `SearchService` to fetch suggestions for products.
The following configuration defines which fields are considered while searching:

``` yaml
ibexa_commerce_search.default.search.auto_suggest_fields:
    - ses_product_ses_sku_value_s
    - ses_product_ses_name_value_s
    - ses_variant_list_s
    - ses_variant_codes_ms
    - ses_variant_sku_ms
    - ses_variant_desc_ms
```

The `ses_variant_*` fields are additional fields that are indexed in Solr.
