# eZ Platform v3.0 project update

Updating to v3.0 requires you to adapt your project and your custom code.
This is due to the switch from Symfony 3 to Symfony 4, as well as due to deprecation of certain features.

## Project structure

!!! tip

    For details on all changes related to the switch to Symfony 4 see [Symfony 4 upgrade doc.](https://github.com/symfony/symfony/blob/master/UPGRADE-4.0.md)

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

## Field Types

To update to v3.0, your Field Type must not implement the `eZ\Publish\SPI\FieldType\Nameable` interface.
Remove the `getFieldName(Value $value, FieldDefinition $fieldDefinition, $languageCode)` method.
You must also adjust `getName()` arguments and add return type hints `string`.

### Extending Field Type templates

If you extended templates for `ezobjectrelationlist_field`, `ezimageasset_field`, or `ezobjectrelation_field` Fields
using `{% extends "@EzPublishCore/content_fields.html.twig" %}`,
you now need to extend `EzSystemsPlatformHttpCache` instead, if you wish to make use of cache:
`{% extends "@EzSystemsPlatformHttpCache/content_fields.html.twig" %}`.

## Configuration

### `ezpublish` configuration key

The main YAML configuration key is now [`ezplatform` instead of `ezpublish`](ez_platform_v3.0_deprecations.md#configuration-through-ezplatform).

### Resolving settings

Due to changes in the way Dependency Injection Container functions in Symfony,
it is recommended to inject the ConfigResolver and get the relevant setting
instead of using dynamic settings (through `$setting$`).

It is also not recommended to get a setting from the ConfigResolver in a class constructor.

If you used either of these options before, it is advisable to rework your code to the new way, for example:

``` php
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

``` php
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

### User checker

Add the user checker to firewall by adding the following line to `config/packages/security.yaml`:

``` yaml
security:
    firewalls:
        ezpublish_front:
            # ...
            user_checker: eZ\Publish\Core\MVC\Symfony\Security\UserChecker
            # ...
```

## Templates

The naming and location of templates in the Back Office have been changed.
If you extend or modify these templates, you need to adapt your code.

For the full list of template changes, see [the list of removals and deprecations](ez_platform_v3.0_deprecations.md#template-organization).

A number of [Twig functions have also been renamed](ez_platform_v3.0_deprecations.md#functions-renamed).

## Custom installers

eZ Platform provides extension point to create named custom installer which can be used instead of the native one.
To use it, execute the Symfony command:

``` bash
php ./bin/console ezplatform:install <installer type name>
```

In eZ Platform v3.0, service definitions around that extension point have changed:

1\. The deprecated Clean Installer has been dropped from `ezpublish-kernel` package.
If your project uses custom installer and has relied on Clean Installer service definition (`ezplatform.installer.clean_installer`) you need to switch to Core Installer.

Before:
    
``` php
services:
    Acme\App\Installer\MyCustomInstaller:
        parent: ezplatform.installer.clean_installer
```

After:
    
``` php
services:
    Acme\App\Installer\MyCustomInstaller:
        parent: EzSystems\PlatformInstallerBundle\Installer\CoreInstaller
```

`CoreInstaller` relies on [`DoctrineSchemaBundle`](https://github.com/ezsystems/doctrine-dbal-schema).
Custom schema can be installed defining Symfony Event Subscriber subscribing to `EzSystems\DoctrineSchema\API\Event\SchemaBuilderEvents::BUILD_SCHEMA` event.

2\. The deprecated Symfony Service definition `ezplatform.installer.db_based_installer` has been removed in favor of its FQCN-named definition.

Before:

``` php
services:
    Acme\App\Installer\MyCustomInstaller:
        parent: ezplatform.installer.db_based_installer
```

After:

``` php
services:
    Acme\App\Installer\MyCustomInstaller:
        parent: EzSystems\PlatformInstallerBundle\Installer\DbBasedInstaller
```

## Packages

Code related to various parts of the application has been moved between repositories.
Change the respective namespaces if your custom code extends any of the following.

### RichText and Online Editor

Online Editor front-end code and assets (such as JS, CSS, fonts, etc.) [have been moved from `ezplatform-admin-ui` to `ezplatform-richtext`](ez_platform_v3.0_deprecations.md#online-editor).

The `ezrichtext` Field Type has been [moved from `ezpublish-kernel` to `ezplatform-richtext`](ez_platform_v3.0_deprecations.md#richtext).

### Repository forms

Content Type editing [has been moved from `repository-forms` to `ezplatform-admin-ui`](ez_platform_v3.0_deprecations.md#content-type-forms).

Forms for content creation have been [moved from `repository-forms` to `ezplatform-content-forms`](ez_platform_v3.0_deprecations.md#repository-forms).

### User settings

User settings have been [moved from `ezplatform-admin-ui` to `ezplatform-user`](ez_platform_v3.0_deprecations.md#user-settings).

### Flex Workflow

[`flex-workflow` has been combined with `ezplatform-workflow`](ez_platform_v3.0_deprecations.md#flex-workflow) in the form of a Quick Review functionality.
