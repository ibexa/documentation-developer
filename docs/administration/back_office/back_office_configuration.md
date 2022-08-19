---
title: Back Office configuration
description: Configure default upload locations, pagination limits, and more settings for the Back Office.
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

## Copy subtree limit

Copying large subtrees can cause performance issues, so you can limit the number of Content items
that can be copied at once using `ibexa.system.<SiteAccess>.subtree_operations.copy_subtree.limit`
in `config/packages/ibexa_admin_ui.yaml`.

The default value is `100`. You can set it to `-1` for no limit,
or to `0` to completely disable copying subtrees.

You can copy subtree from CLI using the command: `bin/console ibexa:copy-subtree <sourceLocationId> <targetLocationId>`.

## Default Locations

Default Location IDs for [Content structure, Media and Users](locations.md#top-level-locations) in the menu are configured using the following settings:

``` yaml
ibexa:
    system:
        default:
            location_ids:
                content_structure: 2
                media: 43
                users: 5
```
