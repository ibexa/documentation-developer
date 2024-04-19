---
description: Configure PIM settings per Repository, with different catalog engines and VAT configurations.
---

# PIM configuration

You can configure PIM per [Repository](repository_configuration.md).

Under `ibexa.repositories.<repository_name>.product_catalog` [configuration key](configuration.md#configuration-files), indicate the catalog engine to use:

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
                root_location_remote_id: e5ce2e391bd94e26a5cd88746f24ecce
                product_type_group_identifier: 'product'
```

The `local` type is the built-in type of catalog based on the Repository.

Under `options.product_type_group_identifier` you can define the identifier of the content type Group used for storing products.

`root_location_remote_id` indicates the remote ID of the Location where products are stored.

## VAT rates

To set up different VAT rates for different regions (countries), you can use the following configuration under the `ibexa.repositories.<repository_name>.product_catalog.regions` [configuration key](configuration.md#configuration-files), for example:

``` yaml hl_lines="11 12 17 18"
ibexa:
    repositories:
        <repository_name>:
            product_catalog:
                engine: default
                regions:
                    <region_name>:
                        vat_categories:
                            standard:
                                value: 18
                                extras:
                                    <custom_flag>: <value>
                            reduced:
                                value: 6
                            zero:
                                value: 0
                            none:
                                value: ~
```

VAT rates configuration accepts additional flags under the `extras` key.
It is an extension point that you can build upon to add custom functionalities. 
You can use it, for example, to pass additional information to the UI or define region-specific exclusions when calculating the tax values.

For each VAT category value, setting a value to "null" (~) is equal to making the following setting:

``` yaml
                            none:
                                value: 0
                                extras:
                                    not_applicable: true
```

## Code generation strategy

Product codes for variants are generated automatically based on the selected strategy.

The following strategies are available:

- `incremental` (default) - variant code consists of base product code plus index, for example: `ErgoDesk-1`, `ErgoDesk-2`.
- `random` - variant code consists of base product code plus random string of characters, for example: `ErgoDesk-62E7B3379AEB4`, `ErgoDesk-62E7B3379AFBC`

You can choose the strategy with the following configuration:

``` yaml hl_lines="8"
ibexa_product_catalog:
    engines:
        default:
            type: local
            options:
                root_location_remote_id: ibexa_product_catalog_root
                product_type_group_identifier: 'product'
                variant_code_generator_strategy: 'random'
```

You can also [create your own custom code generation strategy](create_product_code_generator.md).

## Catalogs

### Catalog filters

You can configure which [catalog filters](catalogs.md) are applied by default with the following configuration:

``` yaml
ibexa:
    system:
        admin:
            product_catalog:
                catalogs:
                    default_filters:
                        - product_code
                        - product_availability
```

The order of filters in this configuration reflects the order in which they are displayed in the Back Office.
