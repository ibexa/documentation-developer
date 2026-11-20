# Product catalog configuration

Configure product catalog settings per repository, with different catalog engines and VAT configurations.

You can configure the product catalog per [Repository](../../administration/configuration/repository_configuration/index.md).

Under `ibexa.repositories.<repository_name>.product_catalog` [configuration key](../../administration/configuration/configuration/index.md#configuration-files), indicate the catalog engine to use:

```yaml
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

```yaml
ibexa_product_catalog:
    engines:
        default:
            type: local
            options:
                root_location_remote_id: e5ce2e391bd94e26a5cd88746f24ecce
                product_type_group_identifier: 'product'
```

The `local` type is the built-in type of catalog based on the content repository. With [Quable PIM integration](../quable/quable_guide/index.md) add-on installed and configured, by using the `quable` type you can retrieve product data coming from Quable.

You can use a single engine across all repositories, or assign different ones per repository. Each repository can use only one product catalog engine.

Under `options.product_type_group_identifier` you can define the identifier of the content type Group used for storing products.

`root_location_remote_id` indicates the remote ID of the location where products are stored.

## VAT rates

To set up different VAT rates for different regions (countries), you can use the following configuration under the `ibexa.repositories.<repository_name>.product_catalog.regions` [configuration key](../../administration/configuration/configuration/index.md#configuration-files), for example:

```yaml
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

VAT rates configuration accepts additional flags under the `extras` key. It's an extension point that you can build upon to add custom functionalities. You can use it, for example, to pass additional information to the UI or define region-specific exclusions when calculating the tax values.

For each VAT category value, setting a value to "null" (~) is equal to making the following setting:

```yaml
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

```yaml
ibexa_product_catalog:
    engines:
        default:
            type: local
            options:
                root_location_remote_id: ibexa_product_catalog_root
                product_type_group_identifier: 'product'
                variant_code_generator_strategy: 'random'
```

You can also [create your own custom code generation strategy](../create_product_code_generator/index.md).

## Attribute rendering templates

You can configure which Twig templates are used to render product attribute values with the [`ibexa_format_product_attribute` Twig filter](../../templating/twig_function_reference/product_twig_functions/index.md#ibexa_format_product_attribute).

```yaml
ibexa_product_catalog:
    templates:
        attributes:
            - 'templates/product/attributes/my_attribute_blocks.html.twig'
```

The default template (`@ibexadesign/product_catalog/product/attributes/attribute_blocks.html.twig`) is always appended as the last fallback, even if not listed explicitly.

For more information, see [Customize product attribute templates](../customize_product_attribute_templates/index.md).

## Catalogs

### Catalog filters

You can configure which [catalog filters](../catalogs/index.md) are applied by default with the following configuration:

```yaml
ibexa:
    system:
        admin:
            product_catalog:
                catalogs:
                    default_filters:
                        - product_code
                        - product_availability
```

The order of filters in this configuration reflects the order in which they're displayed in the back office.
