# Back Office configuration

## Copy subtree limit

Copying large subtrees can cause performance issues, so you can limit the number of Content items
that can be copied at once using `ibexa.system.<SiteAccess>.subtree_operations.copy_subtree.limit`
in `config/packages/ibexa_admin_ui.yaml`.

The default value is `100`. You can set it to `-1` for no limit,
or to `0` to completely disable copying subtrees.

You can copy subtree from CLI using the command: `bin/console ibexa:copy-subtree <sourceLocationId> <targetLocationId>`.

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

Default Location IDs for [Content structure, Media and Users](content_management.md#top-level-locations) in the menu are configured using the following settings:

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

## Date and time formats

Users can set their preferred date and time formats in the User settings menu.
This format is used throughout the Back Office.

You can set the list of available formats with the following configuration:

``` yaml
ibexa:
    system:
        <siteaccess>:
            user_preferences:
                allowed_short_date_formats:
                    'label for dd/MM/yyyy': 'dd/MM/yyyy'
                    'label for MM/dd/yyyy': 'MM/dd/yyyy'
                allowed_short_time_formats:
                    'label for HH:mm' : 'HH:mm'
                    'label for hh:mm a' : 'hh:mm a'
                allowed_full_date_formats:
                    'label for dd/MM/yyyy': 'dd/MM/yyyy'
                    'label for MM/dd/yyyy': 'MM/dd/yyyy'
                allowed_full_time_formats:
                    'label for HH:mm': 'HH:mm'
                    'label for hh:mm a': 'hh:mm a'
```

The default date and time format is set using:

``` yaml
ibexa:
    system:
        <siteaccess>:
            user_preferences:
                short_datetime_format:
                    date_format: 'dd/MM/yyyy'
                    time_format: 'hh:mm'
                full_datetime_format:
                    date_format: 'dd/MM/yyyy'
                    time_format: 'hh:mm'
```

You can also [format date and time](../extending/extending_date_and_time.md) by using Twig filters and PHP services.

### Allowed formats

The following subset of the [ICU date and time formats](https://unicode-org.github.io/icu-docs/apidoc/released/icu4c/classSimpleDateFormat.html#details) is allowed:

|Symbol|Meaning|
|---|---|
|y, yy, yyyy, Y, YY, YYYY|year|
|q, Q|quarter|
|M, MM, MMM, MMMM, L, LL, LLL, LLLL|month|
|w, WW|week|
|d, dd|day of the month|
|D, DDD|day of the year|
|E, EE, EEE, EEEE, EEEEEE, e, ee, eee, eeee, eeeeee, c, cc, ccc, cccc, cccccc|weekday|
|a|AM or PM|
|h, hh, H, HH, k, kk|hour|
|m, mm|minute|
|s, ss, S...|second|
|Z, ZZ, ZZZ, ZZZZZ|timezone|

## Content Tree

With this configuration you can:

- define configuration for a SiteAccess or a SiteAccess group
- decide how many Content items are displayed in the tree
- set maximum depth of expanded tree
- hide Content Types
- set a tree root Location
- override Content Tree's root for specific Locations

```yaml
ibexa:
    system:
        # any SiteAccess or SiteAccess group
        admin_group:
            content_tree_module:
                # defines how many children will be shown after expanding parent
                load_more_limit: 15
                # users won't be able to load more children than that
                children_load_max_limit: 200
                # maximum depth of expanded tree
                tree_max_depth: 10
                # Content Types to display in Content Tree, value of '*' allows all CTs to be displayed
                allowed_content_types: '*'
                # Content Tree won't display these Content Types, can be used only when 'allowed_content_types' is set to '*'
                ignored_content_types:
                   - post
                   - article
                # ID of Location to use as tree root. If omitted - content.tree_root.location_id setting is used.
                tree_root_location_id: 2
                # list of Location IDs for which Content Tree's root Location will be changed
                contextual_tree_root_location_ids:
                   - 2 # Home (Content structure)
                   - 5 # Users
                   - 43 # Media
```

## Universal Discovery Widget

The Universal Discovery Widget (UDW) can be found in [Extending UDW.](../extending/extending_udw.md)

## Icon sets

You can configure icon sets to be used per SiteAccess:

``` yaml
ibexa:
    system:
        <siteaccess>:
            assets:
                icon_sets:
                    my_icons: /assets/images/icons/my_icons.svg
                    additional_icons: /assets/images/icons/additional_icons.svg
                default_icon_set: my_icons
```

## Enabling Commerce features

The `commerce.enabled` setting responsible for displaying the eCommerce tab, Content and Field types for Commerce in the Back Office, is set to `false` by default.
If you want to enable and use Commerce features in Content and Experience editions or Commerce edition, go to `config\packages\ecommerce.yaml`
and set the following:

``` yaml
ibexa:
    system:
        default:
            commerce:
                enabled: true
```

!!! tip

    It is recommended to run `php bin/console cache:clear` between changing the setting and upgrading command.

Because Commerce installation for Content and Experience editions is optional,
to use Commerce features you must install Commerce-related data.
Run the following command:

```bash
php bin/console ibexa:upgrade --force
```
