# Back Office configuration

## Copy subtree limit

Copying large subtrees can cause performance issues, so you can limit the number of Content items
that can be copied at once using `ezpublish.system.<SiteAccess>.subtree_operations.copy_subtree.limit`
in `parameters.yml`.

The default value is `100`. You can set it to `-1` for no limit,
or to `0` to completely disable copying subtrees.

You can copy subtree from CLI using the command: `bin/console ezplatform:copy-subtree <sourceLocationId> <targetLocationId>`.

## Pagination limits

Default pagination limits for different sections of the Back Office can be defined through respective settings in
[`ezplatform_default_settings.yml`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/config/ezplatform_default_settings.yml#L7)

## Default Locations

Default Location IDs for Content structure, Media and Users in the menu are configured using the following settings:

``` yaml
ezsettings.default.location_ids.content_structure: 2
ezsettings.default.location_ids.media: 43
ezsettings.default.location_ids.users: 5
```

You can also set the default starting Location ID for the Universal Discovery Widget:

``` yaml
ezsettings.default.universal_discovery_widget_module.default_location_id: 1
```

## Notification timeout

To define the timeout for hiding Back-Office notification bars, per notification type,
use the following configuration (times are provided in milliseconds):

``` yaml
ezpublish:
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

## Location for Form-uploaded files

You can use Forms to enable the user to upload files.
The default Location for files uploaded in this way is `/Media/Files/Form Uploads`.
You can change it with the following configuration:

``` yaml
ezpublish:
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
ezpublish:
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
ezpublish:
    system:
        <siteaccess>:
            user_preferences:
                short_datetime_format:
                    date_format: 'dd/mm/yyy'
                    time_format: 'hh:mm'
                full_datetime_format:
                    date_format: 'dd/mm/yyy'
                    time_format: 'hh:mm'
```

## Content Tree

With this configuration you can:

- define configuration for a SiteAccess or a SiteAccess group
- decide how many Content items are displayed in the tree
- set maximum depth of expanded tree
- hide Content Types

```yaml
ezpublish:
    system:
        admin_group: # any SiteAccess or SiteAccess group
            content_tree_module:
                load_more_limit: 15 # defines how many children will be shown after expanding parent
                children_load_max_limit: 200 # users won't be able to load more children than that
                tree_max_depth: 10 # maximum depth of expanded tree
                allowed_content_types: # Content Types to display in Content Tree, value of '*' allows all CTs to be displayed  
                   - folder
                   - post
                   - article
                ignored_content_types: # Content Tree won't display these Content Types, can be used only when 'allowed_content_types' is set to '*'
                   - post
                   - article
```
