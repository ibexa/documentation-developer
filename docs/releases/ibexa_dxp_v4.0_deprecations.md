# Ibexa DXP v4.0 deprecations and backwards compatibility breaks

Ibexa DXP v4.0 introduces changes to significant parts of the code
to align with the product name change from earlier eZ Platform.

These changes include changing repository names, namespaces, filenames, function names, and others.

A backwards compatibility layer ensures that custom implementations and extensions
using the older naming should function without change.

## Namespaces

Namespaces in the product which referred to "eZ Platform", "eZ Systems" or "eZ" now use the Ibexa name.

All namespace changes are listed in the `ibexa/compatibility-layer` repository.

Refer to [mapping reference](https://github.com/ibexa/compatibility-layer/tree/main/src/bundle/Resources/mappings)
for a full comparison of old and new bundle names and namespaces.

!!! tip

    To make sure your code is up to date with the new namespaces,
    you can use the [Ibexa PhpStorm plugin](../community_resources/phpstorm_plugin.md).
    The plugin indicates deprecated namespaces and suggests updating them to new ones.

## Configuration keys

`ezplatform` and `ezpublish` configuration keys have been replaced with `ibexa`.

Other package-specific configuration keys have also been updated.

| Old name | New name |
| --- | --- |
| `ezplatform` | `ibexa` |
| `ezpublish` | `ibexa` |
| `ez_doctrine_schema` | `ibexa_doctrine_schema` |
| `ez_io` | `ibexa_io` |
| `ez_platform_fastly_cache` | `ibexa_fastly` |
| `ez_platform_http_cache` | `ibexa_http_cache` |
| `ez_platform_page_builder` | `ibexa_page_builder` |
| `ez_platform_standard_design` | `ibexa_standard_design` |
| `ez_search_engine_legacy` | `ibexa_legacy_search_engine` |
| `ez_search_engine_solr` | `ibexa_solr` |
| `ezdesign` | `ibexa_design_engine` |
| `ezplatform_elastic_search_engine` | `ibexa_elasticsearch` |
| `ezplatform_form_builder` | `ibexa_form_builder` |
| `ezplatform_graphql` | `ibexa_graphql` |
| `ezplatform_page_fieldtype` | `ibexa_fieldtype_page` |
| `ezplatform_support_tools` | `ibexa_system_info` |
| `ezrecommendation` | `ibexa_personalization_client` |
| `ezrichtext` | `ibexa_fieldtype_richtext` |
| `ibexa_platform_commerce_field_types` | `ibexa_commerce_field_types` |
| `one_sky` | `ibexa_commerce_one_sky` |
| `ses_specificationstypefieldtype` | `ibexa_commerce_specifications_type` |
| `shop_price_engine_plugin` | `ibexa_commerce_price_engine` |
| `silversolutions_eshop` | `ibexa_commerce_eshop` |
| `silversolutions_tools` | `ibexa_commerce_shop_tools` |
| `silversolutions_translation` | `ibexa_commerce_translation` |
| `siso_admin_erp` | `ibexa_commerce_erp_admin` |
| `siso_basket` | `ibexa_commerce_basket` |
| `siso_checkout` | `ibexa_commerce_checkout` |
| `siso_comparison` | `ibexa_commerce_comparison` |
| `siso_content_plugin` | `ibexa_commerce_base_design` |
| `siso_ez_studio` | `ibexa_commerce_ez_studio` |
| `siso_local_order_management` | `ibexa_commerce_local_order_management` |
| `siso_newsletter` | `ibexa_commerce_newsletter` |
| `siso_order_history` | `ibexa_commerce_order_history` |
| `siso_payment` | `ibexa_commerce_payment` |
| `siso_price` | `ibexa_commerce_price` |
| `siso_quick_order` | `ibexa_commerce_quick_order` |
| `siso_search` | `ibexa_commerce_search` |
| `siso_shop_frontend` | `ibexa_commerce_shop_frontend` |
| `siso_test` | `ibexa_commerce_test_tools` |
| `siso_tools` | `ibexa_commerce_tools` |
| `siso_voucher` | `ibexa_commerce_voucher` |

## CSS classes for Back Office

CSS classes with the `ez-` prefix have been modified with an `ibexa-` prefix.

## JavaScript event names

JavaScript event names with the `ez-` prefix have been modified with an `ibexa-` prefix, for example:

`ez-notify` > `ibexa-notify`
`ez-content-tree-refresh` > `ibexa-content-tree-refresh`

## REST endpoint prefix

TODO

## Twig functions and filter

The following Twig functions and filter have been renamed, including:

| Old name | New name |
| --- | --- |
| `ez_content_name` | `ibexa_content_name` |
| `ez_render_field` | `ibexa_render_field` |
| `ez_render` | `ibexa_render` |
| `ez_field` | `ibexa_field` |
| `ez_image_alias` | `ibexa_image_alias` |

For a full list of changed Twig function and filter names, see TODO.

## Configuration file names

Built-in configuration files starting with `ezplatform` now use names with `ibexa`, including:

| Old name | New name |
| --- | --- |
| `ezplatform.yaml` | `ibexa.yaml` |
| `ezplatform_admin_ui.yaml` | `ibexa_admin_ui.yaml` |
| `ezplatform_assets.yaml` | `ibexa_assets.yaml` |
| `ezplatform_doctrine_schema.yaml` | `ibexa_doctrineschema.yaml` |
| `ezplatform_elastic_search_engine.yaml` | `ibexa_elasticsearch.yaml` |
| `ezplatform_form_builder.yaml` | `ibexa_form_builder.yaml` |
| `ezplatform_http_cache.yaml` | `ibexa_http_cache.yaml` |
| `ezplatform_http_cache_fastly.yaml` | `ibexa_fastly.yaml` |
| `ezplatform_page_builder.yaml` | `ibexa_page_builder.yaml` |
| `ezplatform_site_factory.yaml` | `ibexa_site_factory.yaml` |
| `ezplatform_solr.yaml` | `ibexa_solr.yaml` |
| `ezplatform_welcome_page.yaml` | `ibexa_welcome_page.yaml` |

## Minor changes

- `AbstractBuilder::createMenuItem` return type is now `ItemInterface` only.
