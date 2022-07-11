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

## Notification timeout

To define the timeout for hiding Back-Office notification bars, per notification type,
use the following configuration (times are provided in milliseconds):

``` yaml
ibexa:
    system:
        admin:
            notifications:
                error:
                    timeout: 0
                warning:
                    timeout: 0
                success:
                    timeout: 5000
                info:
                    timeout: 0
```

The values shown above are the defaults. `0` means the notification does not hide automatically.

## Form-uploaded files

You can use Forms to enable the user to upload files.
The default Location for files uploaded in this way is `/Media/Files/Form Uploads`.
You can change it with the following configuration:

``` yaml
ibexa:
    system:
        default:
            form_builder:
                upload_location_id: 54
```

This applies only if no specific Location is defined in the Form itself.

#

## Universal Discovery Widget

The Universal Discovery Widget (UDW) can be found in [Extending UDW.](../../extending/extending_udw.md)
