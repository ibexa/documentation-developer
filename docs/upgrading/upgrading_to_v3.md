# Upgrading eZ Platform to v3.0

The following upgrade documentation describes how to upgrade eZ Platform from v2.5 to v3.0.

If you are upgrading from a version lower than v2.5, follow the [standard update procedure](../updating/updating_ez_platform.md) first.
Do not proceed with an upgrade to v3.0 before you complete an update to v2.5.

## Familiarize yourself with a new project structure

!!! tip

    If you are running into issues, for details on all changes related to the switch to Symfony 5,
    see [Symfony upgrade guide for 4.0](https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.0.md)
    and [for 5.0](https://github.com/symfony/symfony/blob/5.0/UPGRADE-5.0.md)

The latest Symfony versions changed the organization of your project into folders and bundles.
When updating to eZ Platform v3 you need to move your files and modify file paths and namespace references.

![Project structure changes in v3](../updating/img/folder_structure_v3.png "Project folder structure changes between v2 and v3")

### Configuration

Configuration files have been moved from `app/Resources/config` to `config`.
Package-specific configuration is placed in `config/packages` (e.g. `config/packages/ezplatform_admin_ui.yaml`).
This folder also contains `config/packages/ezplatform.yaml`, which contains all settings coming in from Kernel.

### PHP code and bundle organization

Since Symfony 4 `src/` code is no longer organized in bundles, `AppBundle` has been removed from the default eZ Platform install.
In order to adapt, you'll need to move all your PHP code, such as controllers or event listeners, to the `src` folder and use the `App` namespace for your custom code instead.

!!! tip "How to make AppBundle continue to work, for now"

    Refactoring bundles for `src/` folder can involve extensive changes, if you want to make your `src/AppBundle` continue to work, follow [an Autoloading src/AppBundle guide on Symfony Casts](https://symfonycasts.com/screencast/symfony4-upgrade/flex-composer.json#autoloading-src-amp-src-appbundle).
    
    You can also follow [Using a "path" Repository guide,](https://symfonycasts.com/screencast/symfony-bundle/extracting-bundle#using-a-path-repository) to create a [composer path repository.](https://getcomposer.org/doc/05-repositories.md#path)
    If you have several bundles you can move them into a `packages/` directory and load them all with:
    
    ```
    "repositories": [
        { "type": "path", "url": "packages/*" },
    ],
    ```
    
    Once you are ready to refactor the code to `App` namespace, follow [Bye Bye AppBundle chapter.](https://symfonycasts.com/screencast/symfony4-upgrade/bye-appbundle)

### View templates

Templates are no longer stored in `app/Resources/views`.
You need to move all your templates to the `templates` folder in your project's root.

### Translations

Translation files have been moved out of `app/Resources/translations` into `translations` in your project's root.

### `web` and assets

Content of the `web` folder is now placed in `public`.
Content of `app/Resources/assets` has been moved to `assets`.

!!! note

    You also need to update paths that refer to the old location,
    for example in [`webpack.config.js`](../guide/project_organization.md#importing-configuration-from-a-bundle).
