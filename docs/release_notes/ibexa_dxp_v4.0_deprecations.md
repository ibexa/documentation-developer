<!-- vale VariablesVersion = NO -->

# Ibexa DXP v4.0 deprecations and backwards compatibility breaks

[[= product_name =]] v4.0 introduces changes to significant parts of the code
to align with the product name change from earlier eZ Platform.

These changes include changing repository names, namespaces, filenames, function names, and others.

A backwards compatibility layer ensures that custom implementations and extensions
using the older naming should function without change.

## Namespaces

Namespaces in the product which referred to old product names now use the [[= product_name_base =]] name.

All namespace changes are listed in the `ibexa/compatibility-layer` repository.

Refer to [mapping reference](https://github.com/ibexa/compatibility-layer/tree/4.6/src/bundle/Resources/mappings)
for a full comparison of old and new bundle names and namespaces.

!!! tip

    To make sure your code is up to date with the new namespaces,
    you can use the [Ibexa PhpStorm plugin](phpstorm_plugin.md).
    The plugin indicates deprecated namespaces and suggests updating them to new ones.

### Richtext namespace

The internal format of richtext has changed. 

All namespace changes are listed in the
[richtext](https://github.com/ibexa/fieldtype-richtext/blob/bf45e57ea1d2933cc02eb8d8bff76c0925de92de/src/bundle/Resources/config/default_settings.yaml#L60-L67) repository.

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
| `ezrichtext.custom_styles.<style_name>.is_inline` | `ibexa_fieldtype_richtext.custom_styles.<style_name>.inline` |
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

## Service names

Service names which referred to old product names now use the [[= product_name_base =]] name.

All service name changes are listed in the `ibexa/compatibility-layer` repository.

Refer to [mapping reference](https://github.com/ibexa/compatibility-layer/blob/4.6/src/bundle/Resources/mappings/services-to-fqcn-map.php)
for a full comparison of old and new names.

## Service tags

Service tag which referred to old product names now use the [[= product_name_base =]] name.

All service tag changes are listed in the `ibexa/compatibility-layer` repository.

Refer to [mapping reference](https://github.com/ibexa/compatibility-layer/blob/4.6/src/bundle/Resources/mappings/symfony-service-tag-name-map.php)
for a full comparison of old and new service tags.

## CSS classes for back office

CSS classes with the `ez-` prefix have been modified with an `ibexa-` prefix.

## JavaScript event names

JavaScript event names with the `ez-` prefix have been modified with an `ibexa-` prefix, for example:

`ez-notify` > `ibexa-notify`
`ez-content-tree-refresh` > `ibexa-content-tree-refresh`

## REST API

REST API route prefix has changed from `/api/ezp/v2/` to `/api/ibexa/v2/`.

REST API media types have changed from `application/vnd.ez.api.*` to `application/vnd.ibexa.api.*`.

## Twig functions and filters

The following Twig functions and filter have been renamed, including:

| Old name | New name |
| --- | --- |
| `ez_content_name` | `ibexa_content_name` |
| `ez_render_field` | `ibexa_render_field` |
| `ez_render` | `ibexa_render` |
| `ez_field` | `ibexa_field` |
| `ez_image_alias` | `ibexa_image_alias` |

??? note "Full list of changed Twig function and filter names"

    | Old name | New name |
    | --- | --- |
    | `calculate_shipping` | `ibexa_commerce_calculate_shipping` |
    | `code_label` | `ibexa_commerce_code_label` |
    | `date_format` | `ibexa_commerce_date_format` |
    | `ez_content_field_identifier_first_filled_image` | `ibexa_content_field_identifier_first_filled_image` |
    | `ez_content_field_identifier_image_asset` | `ibexa_content_field_identifier_image_asset` |
    | `ez_content_name` | `ibexa_content_name` |
    | `ez_content_type_icon` | `ibexa_content_type_icon` |
    | `ez_data_attributes_serialize` | `ibexa_data_attributes_serialize` |
    | `ez_datetime_diff` | `ibexa_datetime_diff` |
    | `ez_field_description` | `ibexa_field_description` |
    | `ez_field_is_empty` | `ibexa_field_is_empty` |
    | `ez_field_name` | `ibexa_field_name` |
    | `ez_field_value` | `ibexa_field_value` |
    | `ez_field` | `ibexa_field` |
    | `ez_file_size` | `ibexa_file_size` |
    | `ez_full_date` | `ibexa_full_date` |
    | `ez_full_datetime` | `ibexa_full_datetime` |
    | `ez_full_time` | `ibexa_full_time` |
    | `ez_http_cache_tag_location` | `ibexa_http_cache_tag_location` |
    | `ez_http_tag_location` | `ibexa_http_cache_tag_location` |
    | `ez_http_tag_relation_ids` | `ibexa_http_cache_tag_relation_ids` |
    | `ez_http_tag_relation_location_ids` | `ibexa_http_cache_tag_relation_location_ids` |
    | `ez_image_alias` | `ibexa_image_alias` |
    | `ez_page_layout` | `ibexa_page_layout` |
    | `ez_path_to_locations` | `ibexa_path_to_locations` |
    | `ez_path` | `ibexa_path` |
    | `ez_recommendation_enabled` | `ibexa_recommendation_enabled` |
    | `ez_recommendation_track_user` | `ibexa_recommendation_track_user` |
    | `ez_render_*_query_*` | `ibexa_render_*_query_` |
    | `ez_render_*_query` | `ibexa_render_*_query` |
    | `ez_render_comparison_result` | `ibexa_render_comparison_result `|
    | `ez_render_content` | `ibexa_render_content` |
    | `ez_render_field_definition_settings` | `ibexa_render_field_definition_settings` |
    | `ez_render_field` | `ibexa_render_field` |
    | `ez_render_limitation_value` | `ibexa_render_limitation_value` |
    | `ez_render_location` | `ibexa_render_location` |
    | `ez_render` | `ibexa_render` |
    | `ez_richtext_to_html5_edit` | `ibexa_richtext_to_html5_edit` |
    | `ez_richtext_to_html5` | `ibexa_richtext_to_html5` |
    | `ez_richtext_youtube_extract_id` | `ibexa_richtext_youtube_extract_id` |
    | `ez_route` | `ibexa_route` |
    | `ez_short_date` | `ibexa_short_date` |
    | `ez_short_datetime` | `ibexa_short_datetime` |
    | `ez_short_time` | `ibexa_short_time` |
    | `ez_url` | `ibexa_url` |
    | `get_characteristics_b2b` | `ibexa_commerce_get_characteristics_b2b` |
    | `get_relation_content` | `ibexa_commerce_get_relation_content` |
    | `get_search_query` | `ibexa_commerce_get_search_query` |
    | `get_shipping_free_value` | `ibexa_commerce_get_shipping_free_value` |
    | `get_siteaccess_locale` | `ibexa_commerce_get_siteaccess_locale` |
    | `get_stored_baskets` | `ibexa_commerce_get_stored_baskets` |
    | `ibexa_commerce_render_stock` | `ibexa_commerce_render_stock` |
    | `ibexa_platform_asset` | `ibexa_dam_asset` |
    | `ibexa_platform_dam_image_transformation` | `ibexa_dam_image_transformation` |
    | `is_shipping_free` | `ibexa_commerce_is_shipping_free` |
    | `price_format` | `ibexa_commerce_price_format` |
    | `ses_assets_by_group` | `ibexa_commerce_assets_by_group` |
    | `ses_assets_image_list` | `ibexa_commerce_assets_image_list` |
    | `ses_assets_main_image` | `ibexa_commerce_assets_main_image` |
    | `ses_basket` | `ibexa_commerce_basket` |
    | `ses_check_product_in_comparison` | `ibexa_commerce_check_product_in_comparison` |
    | `ses_check_product_in_wish_list` | `ibexa_commerce_check_product_in_wish_list` |
    | `ses_comparison_category` | `ibexa_commerce_comparison_category` |
    | `ses_config_parameter` | `ibexa_commerce_config_parameter` |
    | `ses_contains_basket_vouchers` | `ibexa_commerce_contains_basket_vouchers` |
    | `ses_content_pagination` | `ibexa_commerce_content_pagination` |
    | `ses_correct_url` | `ibexa_commerce_correct_url` |
    | `ses_erp_to_default` | `ibexa_commerce_erp_to_default` |
    | `ses_format_args` | `ibexa_commerce_format_args` |
    | `ses_get_basket_vouchers` | `ibexa_commerce_get_basket_vouchers` |
    | `ses_invoice_number` | `ibexa_commerce_invoice_number` |
    | `ses_navigation` | `ibexa_commerce_navigation` |
    | `ses_pagination` | `ibexa_commerce_pagination` |
    | `ses_product` | `ibexa_commerce_product` |
    | `ses_render_field` | `ibexa_commerce_render_field` |
    | `ses_render_price` | `ibexa_commerce_render_price` |
    | `ses_render_specification_matrix` | `ibexa_commerce_render_specification_matrix` |
    | `ses_render_stock` | `ibexa_commerce_render_stock` |
    | `ses_scope_request_active` | `ibexa_commerce_scope_request_active` |
    | `ses_to_float` | `ibexa_commerce_to_float` |
    | `ses_total_comparison` | `ibexa_commerce_total_comparison` |
    | `ses_track_base` | `ibexa_commerce_track_base` |
    | `ses_track_basket` | `ibexa_commerce_track_basket` |
    | `ses_track_product` | `ibexa_commerce_track_product` |
    | `ses_user_menu` | `ibexa_commerce_user_menu` |
    | `ses_variant_product_by_sku` | `ibexa_commerce_variant_product_by_sku` |
    | `ses_wish_list` | `ibexa_commerce_wish_list` |
    | `sort_characteristic_codes` | `ibexa_commerce_sort_characteristic_codes` |
    | `sort_characteristics` | `ibexa_commerce_sort_characteristics` |
    | `st_image` | `ibexa_commerce_image` |
    | `st_imageconverter` | `ibexa_commerce_imageconverter` |
    | `st_resolve_template` | `ibexa_commerce_resolve_template` |
    | `st_siteaccess_lang` | `ibexa_commerce_siteaccess_lang` |
    | `st_siteaccess_path` | `ibexa_commerce_siteaccess_path` |
    | `st_siteaccess_url` | `ibexa_commerce_siteaccess_url` |
    | `st_tag` | `ibexa_commerce_tag` |
    | `st_translate` | `ibexa_commerce_translate` |
    | `truncate` | `ibexa_commerce_truncate` |
    | `unserialize` | `ibexa_commerce_unserialize` |
    | `youtube_video_id` | `ibexa_commerce_youtube_video_id` |


## URL Alias route name
URL Alias route name has changed from `ez_urlalias` to `ibexa.url.alias`.

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
- Meaningless properties added to the Doctrine schema now throw an exception.
This is prevents indexes from being placed erroneously in the root table.
- The following deprecated service tags have been dropped: `ezsystems.platformui.application_config_provider`,
`ezpublish.content_view_provider`, `ezpublish.fieldType`, `ezpublish.fieldType.parameterProvider`,
`ezpublish.fieldType.indexable`, `ezpublish.fieldType.externalStorageHandler`, `ezpublish.fieldType.externalStorageHandler.gateway`,
`ezpublish.location_view_provider`, `ezpublish.query_type`, `ezpublish.searchEngineIndexer`,
`ezpublish.searchEngine`, `ezpublish.storageEngine.legacy.converter`
- `Ibexa\Contracts\Core\MVC\EventSubscriber\onConfigScopeChange::onConfigScopeChange` now takes `ScopeChangeEvent $event` instead of `SiteAccess $siteAccess` as argument.
