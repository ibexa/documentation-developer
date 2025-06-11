---
description: Add the option to select a custom preference in user menu.
---

# Add user setting

## Create new user setting

You can add new preferences to the **User Settings** menu in the back office.

To do so, create a setting class implementing two interfaces: `ValueDefinitionInterface` and `FormMapperInterface`.

In this example the class is located in `src/Setting/Unit.php` and enables the user to select their preference for metric or imperial unit systems.

``` php
[[= include_file('code_samples/back_office/settings/src/Setting/Unit.php') =]]
```

Register the setting as a service:

``` yaml
[[= include_file('code_samples/back_office/settings/config/custom_services.yaml', 0, 5) =]]
```

You can order the settings in the **User** menu by setting their `priority`.

`group` indicates the group that the setting is placed in.
It can be one of the built-in groups, or a custom one.

To create a custom setting group, create an `App/Setting/Group/MyGroup.php` file:

``` php
[[= include_file('code_samples/back_office/settings/src/Setting/Group/MyGroup.php') =]]
```

Register the setting group as a service:

``` yaml
[[= include_file('code_samples/back_office/settings/config/custom_services.yaml', 6, 9) =]]
```

The value of the setting is accessible with `ez_user_settings['unit']`.

## Create template for editing settings

You can override a template used when editing the new setting under the `ibexa.system.<scope>.user_settings_update_view` [configuration key](configuration.md#configuration-files):

``` yaml
[[= include_file('code_samples/back_office/settings/config/packages/user_settings.yaml') =]]
```

The `templates/themes/admin/user/setting/update_unit.html.twig` template must extend the `@ibexadesign/account/settings/update.html.twig` template:

``` html+twig
[[= include_file('code_samples/back_office/settings/templates/themes/admin/user/setting/update_unit.html.twig') =]]
```
