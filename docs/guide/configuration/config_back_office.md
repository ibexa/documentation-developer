---
description: Configure default upload locations, pagination limits, date and time, and more settings for the Back Office.
---

# Back Office configuration


## Pagination limits

Default pagination limits for different sections of the Back Office can be defined through respective settings in
[`ezplatform_default_settings.yaml`](https://github.com/ibexa/admin-ui/blob/main/src/bundle/Resources/config/ezplatform_default_settings.yaml#L7)

You can set the pagination limit for user settings with the following configuration:

``` yaml
ibexa:
    system:
        default:
            pagination_user:
                user_settings_limit: 6
```

You can configure the following settings to manage the pagination limits for the product catalog:

``` yaml
ezsettings.default.product_catalog.pagination.attribute_groups_limit: 25
ezsettings.default.product_catalog.pagination.customer_groups_limit: 25
ezsettings.default.product_catalog.pagination.products_limit: 25
ezsettings.default.product_catalog.pagination.product_types_limit: 25
```

## Default Locations

Default Location IDs for [Content structure, Media and Users](../content_management.md#top-level-locations) in the menu are configured using the following settings:

``` yaml
ibexa:
    system:
        default:
            location_ids:
                content_structure: 2
                media: 43
                users: 5
```

## Universal Discovery Widget

The Universal Discovery Widget (UDW) can be found in [Extending UDW.](../../extending/extending_udw.md)
