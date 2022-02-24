# Catalog configuration

You can configure the product catalog per [Repository](../config_repository.md).

Under `ibexa.repositories.<repository_name>.product_catalog`, indicate the catalog engine to use:

``` yaml
ibexa:
    repositories:
        default:
            storage: ~
            search:
                engine: '%search_engine%'
                connection: default
            product_catalog:
                engine: 'default'
```

The `default` engine is available out of the box, and configured under `ibexa_product_catalog`:

``` yaml
ibexa_product_catalog:
    engines:
        default:
            type: local
            options:
                ibexa_product_catalog_root: 12
                product_type_group_identifier: 'product'
```

The `local` type is the built-in type of catalog based on the Repository.

Under `options.product_type_group_identifier` you can define the identifier of the Content Type group used for storing products.

`root_location_remote_id` indicates the ID of the Location where products are stored.

## VAT rates

To set up different VAT rates for different regions (countries), you can use the following configuration:

``` yaml
ibexa_product_catalog:
    regions:
        region_1:
            vat_categories:
                standard: 12
                reduced: 8
                zero: 0
        region_2:
            vat_categories:
                standard: 24
                reduced: 12
                zero: 0
```

`ibexa_product_catalog.regions` enables you to configure global regions which have different VAT rules,
with their specific VAT rates.

You can override the global configuration per scope under `ibexa.system.<scope>.product_catalog.regions`:

``` yaml
ibexa:
    system:
        <scope>:
            product_catalog:
                regions:
                    region_1:
                        vat_categories:
                            standard: 18
                            reduced: 6
                            none: ~
```
