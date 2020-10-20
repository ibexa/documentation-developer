# Quick order API

Quick order uses Solr to search for products and variants.

## Configuration

``` yaml
parameters:
    siso_quickorder.default.autosuggest_delimiters: [' ', '/', '-', '::']

    siso_quickorder.default.csv_delimiters: [';', ',']

    #this delimiter must be part of the siso_quickorder.default.autosuggest_delimiters
    #this delimiter can not be a part of sku or variant code!!!
    siso_quickorder.default.sku_variant_code_delimiter: '::'

    # Columns of the CSV file.
    # The order is important, as it reflects the order in the file.
    siso_quickorder.default.csv_data:
        - sku
        - variantCode
        - quantity
        - customText
```

## Indexing variants and products in Solr

Autosuggest uses `SearchService` to fetch suggestions for products.
Configuration defines which fields are considered while searching:

``` yaml
siso_solr.default.search.auto_suggest_fields:
    - attr_ses_sku_s
    - attr_ses_name_t
    - ses_variant_list_s
    - ses_variant_codes____s
    - ses_variant_sku____s
    - ses_variant_desc____s
    - ses_variant_main_sku_s
```

The `ses_variant_\*` fields are additional fields indexed in the Solr.
The standard shop is able to index the variant fields stored in Matrix Field.

For projects which extend the product's Content Type with new fields, the indexer has to be extended as well:

``` 
"ses_variant_codes____s": [
          "var-wht",
          "var-blk"
        ],
        "ses_variant_sku____s": [
          "se0101",
          "se0101"
        ],
        "ses_variant_desc____s": [
          "xi-5",
          "white",
          "xi-5",
          "black"
        ],
        "ses_variant_list_s": "[{\"sku\":\"SE0101\",\"variantCode\":\"VAR-WHT\",\"description\":\"XI-5 white\",\"characteristicCodeColor\":\"Wei\\u00df\",\"characteristicLabelColor\":\"Wei\\u00df\",\"characteristicCodeUnit\":\"\",\"characteristicLabelUnit\":\"\",\"priceNet\":\"149,00\",\"vatPercent\":\"19\",\"dataMap_countryOfOrigin\":\"\",\"characteristicCodeWidth\":\"\",\"characteristicLabelWidth\":\"\"},{\"sku\":\"SE0101\",\"variantCode\":\"VAR-BLK\",\"description\":\"XI-5 black\",\"characteristicCodeColor\":\"Schwarz\",\"characteristicLabelColor\":\"Schwarz\",\"characteristicCodeUnit\":\"\",\"characteristicLabelUnit\":\"\",\"priceNet\":\"149,00\",\"vatPercent\":\"19\",\"dataMap_countryOfOrigin\":\"\",\"characteristicCodeWidth\":\"\",\"characteristicLabelWidth\":\"\"}]",
        "ses_variant_main_sku_s": "se0101",
```

### Solr attributes

#### ses_variant_codes____s

A list of variant codes used for this product.

Examples: `var-wht`, `var-blk`

#### ses_variant_sku____s

A list of corresponding SKUs.

Examples: `se0101`, `se0101`

#### ses_variant_desc____s

A list of words in lower case used for the description of variants.

Examples: `xi-5`, `white`, `xi-5`, `black`

#### ses_variant_list_s

A JSON version of the variants using these fields.

Example:

```` json
Array
(
    [0] => stdClass Object
        (
            [sku] => SE0101
            [variantCode] => VAR-WHT
            [description] => XI-5 white
            [characteristicCodeColor] => Weiu00df
            [characteristicLabelColor] => Weiu00df
            [characteristicCodeUnit] =>
            [characteristicLabelUnit] =>
            [priceNet] => 149,00
            [vatPercent] => 19
            [dataMap_countryOfOrigin] =>
            [characteristicCodeWidth] =>
            [characteristicLabelWidth] =>
        )
    [1] => stdClass Object
        (
            [sku] => SE0101
            [variantCode] => VAR-BLK
            [description] => XI-5 black
            [characteristicCodeColor] => Schwarz
            [characteristicLabelColor] => Schwarz
            [characteristicCodeUnit] =>
            [characteristicLabelUnit] =>
            [priceNet] => 149,00
            [vatPercent] => 19
            [dataMap_countryOfOrigin] =>
            [characteristicCodeWidth] =>
            [characteristicLabelWidth] =>
        )
````

#### ses_variant_main_sku_s

The SKU of the main product.

Example: `se0101`
