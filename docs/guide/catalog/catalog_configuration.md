---
description: Configure product catalog per Repository, with different catalog engines and VAT configurations.
---

# Catalog configuration

You can configure the product catalog per [Repository](../configuration/config_repository.md).

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
                root_location_remote_id: e5ce2e391bd94e26a5cd88746f24ecce
                product_type_group_identifier: 'product'
```

The `local` type is the built-in type of catalog based on the Repository.

Under `options.product_type_group_identifier` you can define the identifier of the Content Type group used for storing products.

`root_location_remote_id` indicates the remote ID of the Location where products are stored.

## VAT rates

To set up different VAT rates for different regions (countries), you can use the following configuration under `ibexa.repositories.<scope>.product_catalog.regions`:

``` yaml
ibexa:
    repositories:
        <scope>:
            product_catalog:
                engine: default
                regions:
                    region_1:
                        vat_categories:
                            standard: 18
                            reduced: 6
                            none: ~
```
