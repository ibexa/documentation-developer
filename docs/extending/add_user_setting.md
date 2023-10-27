---
description: Add the option to select a custom preference in user menu.
---

# Add user setting

## Create new User setting

You can add new preferences to the **User Settings** menu in the Back Office.

To do so, create a setting class implementing two interfaces:
`ValueDefinitionInterface` and `FormMapperInterface`.

In this example the class is located in `src/Setting/Unit.php`
and enables the user to select their preference for metric or imperial unit systems.

``` php
[[= include_file('code_samples/back_office/settings/src/Setting/Unit.php') =]]
```

Register the setting as a service:

``` yaml
[[= include_file('code_samples/back_office/settings/config/custom_services.yaml' )=]]
```

You can order the settings in the User menu by setting their `priority`.

The value of the setting is accessible with `ez_user_settings['unit']`.

## Create template for editing settings

You can override a template used when editing the new setting:

``` yaml
[[= include_file('code_samples/back_office/settings/config/packages/user_settings.yaml' )=]]
```

The `templates/User/Setting/update_unit.html.twig` template must extend the `@ezdesign/account/settings/update.html.twig` template:

``` html+twig
[[= include_file('code_samples/back_office/settings/templates/User/Setting/update_unit.html.twig' )=]]
```
