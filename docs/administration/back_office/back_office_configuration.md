---
title: Back Office configuration
description: Configure default upload locations, pagination limits, and more settings for the Back Office.
---

# Back Office configuration

## Pagination limits

Default pagination limits for different sections of the Back Office can be defined through respective settings in
[`ezplatform_default_settings.yaml`](https://github.com/ibexa/admin-ui/blob/main/src/bundle/Resources/config/ezplatform_default_settings.yaml#L7)

You can set the pagination limit for user settings under the `ibexa.system.<scope>.pagination_user` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        <scope>:
            pagination_user:
                user_settings_limit: 6
```

You can configure the following settings to manage the pagination limits for the product catalog:

``` yaml
ibexa:
    system:
        <scope>:
            product_catalog:
                pagination:
                    attribute_definitions_limit: 10
                    attribute_groups_limit: 10
                    customer_groups_limit: 10
                    customer_group_users_limit: 10
                    products_limit: 10
                    product_types_limit: 10
                    product_view_custom_prices_limit: 10
                    regions_limit: 10
                    catalogs_limit: 10
```

## Copy subtree limit

Copying large subtrees can cause performance issues, so you can limit the number of Content items
that can be copied at once using the `ibexa.system.<scope>.subtree_operations.copy_subtree.limit`
[configuration key](configuration.md#configuration-files).

The default value is `100`. You can set it to `-1` for no limit,
or to `0` to completely disable copying subtrees.

You can copy subtree from CLI using the command: `bin/console ibexa:copy-subtree <sourceLocationId> <targetLocationId>`.

## Default Locations

Default Location IDs for [Content structure, Media and Users](locations.md#top-level-locations) in the menu are configured
using the `ibexa.system.<scope>.location_ids` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        <scope>:
            location_ids:
                content_structure: 2
                media: 43
                users: 5
```
