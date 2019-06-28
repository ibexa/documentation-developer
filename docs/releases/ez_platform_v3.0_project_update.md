# eZ Platform v3.0 project update

Updating to v3.0 requires you to adapt your project and your custom code.
This is due to the switch from Symfony 3 to Symfony 4, as well as due to deprecation of certain features.

## Project structure

!!! tip

    Refer to [Symfony 4 upgrade doc](https://github.com/symfony/symfony/blob/master/UPGRADE-4.0.md)
    for details of all changes related to the switch to Symfony 4.

Symfony 4 changes the organization of your project into folders and bundles.
When updating to eZ Platform v3.0 you need to move your files and modify file paths and namespace references.

### Configuration

Configuration files have been moved from `app/Resources/config` to `config`.
Package-specific configuration is placed in `config/packages` (e.g. `config/packages/ezplatform_admin_ui.yaml`).
This folder also contains `config/packages/ezplatform.yaml`, which contains all settings coming in from the Kernel.

### PHP code and bundle organization

In Symfony 4 your code is no longer organized in bundles.
The `AppBundle` has been removed from eZ Platform.
Instead, place all your PHP code, such as controllers or event listeners, in the `src` folder.
Use the `App` namespace for your custom code instead.

### View templates

Templates are no longer stored in `app/Resources/views`.
Instead, place all your templates in the `templates` folder in your project's root.

### Translations

Translation files have been moved out of `app/Resources/translations` into `translations` in your project's root.

### `web` and assets

Content of the `web` folder is now placed in `public`.
Content of `app/Resources/assets` has been moved to `assets`.

## Replacing SignalSlots with Events

v3.0 removes SignalSlots and replaces them with Symfony Events.
To use them, create [Event Listeners](https://symfony.com/doc/4.3/event_dispatcher.html) in your code.

## Field Types

To update to v3.0, your Field Type must not implement the `eZ\Publish\SPI\FieldType\Nameable` interface.
Remove the `getFieldName(Value $value, FieldDefinition $fieldDefinition, $languageCode)` method.
You must also adjust `getName()` arguments and add return type hints `string`.

## HTTP cache

## Resolving settings

Due to changes in the way Dependency Injection Container functions in Symfony,
it is recommended to inject the ConfigResolver and get the relevant setting
instead of using dynamic settings (through `$setting$`).

It is also not recommended to get a setting from the ConfigResolver in a class constructor.

If you used either of these options before, it is advisable to rework your code to the new way, for example:

```
<?php

use eZ\Publish\Core\MVC\ConfigResolverInterface;

class MyService
{
    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface */
    private $configResolver;

    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public function myMethodWhichUsesSetting(): void
    {
        $setting = $this->configResolver->getParameter('setting');
    }
}
```

instead of:

```
<?php

use eZ\Publish\Core\MVC\ConfigResolverInterface;

class MyService
{
    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->setting = $configResolver->getParameter('setting');
    }

}
```

## Renamed templates and template parameters

The naming and location of templates in the Back Office have been changed.
If you extend or modify these templates, you need to adapt your code.

Refer to [the list of removals and deprecations](ez_platform_v3.0_deprecations.md#template-organization)
for a full list of changes.
