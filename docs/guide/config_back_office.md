# Back Office configuration

## Default page

You can define the default page that will be shown after user login.
This overrides Symfony's `default_target_path`, and enables you to configure redirection per SiteAccess.

``` yaml
ezpublish:
    system:
        ezdemo_site:
            default_page: "/Getting-Started"

        ezdemo_site_admin:
            # For admin, redirect to dashboard after login.
            default_page: "/content/dashboard"
```

This setting **does not change Symfony behavior** regarding redirection after login. If set, it will only substitute the value set for `default_target_path`. It is therefore still possible to specify a custom target path using a dedicated form parameter.

**Order of precedence is not modified.**

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

### Default Location IDs for Content structure, Media and Users in the menu

``` yaml
# System Location IDs
ezsettings.default.location_ids.content_structure: 2
ezsettings.default.location_ids.media: 43
ezsettings.default.location_ids.users: 5
```

### Default starting Location ID for the Universal Discovery Widget

``` yaml
# Universal Discovery Widget Module
ezsettings.default.universal_discovery_widget_module.default_location_id: 1
```

## Notification timeout

To define the timeout for hiding Back-Office notification bars, use the following configuration,
per notification type:

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

The values shown above are the defaults (in milliseconds). `0` means the notification does not hide automatically.

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
