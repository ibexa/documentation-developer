# 4. Upgrade the code

If you are updating to v3.0 from a lower version, you need to make a number of modifications to your code.

!!! caution

    Perform these steps only if you are updating to version v3.0.
    If not, move on to the [5. Update the database](5_update_database.md) step.

## Familiarize yourself with a new project structure

!!! tip

    If you run into issues, for details on all changes related to the switch to Symfony 5,
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
    
    Once you are ready to refactor the code to `App` namespace, follow [Bye Bye AppBundle](https://symfonycasts.com/screencast/symfony4-upgrade/bye-appbundle) article.

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

!!! note "Full list of deprecations"

    If you encounter any issue during the upgrade,
    see [eZ Platform v3.0 deprecations](../releases/ez_platform_v3.0_deprecations.md#template-organization)
    for details of all required changes to your code.

## Third-party dependencies

Because eZ Platform v3 is based on Symfony 5, you need to make sure all additional third-party dependencies
that your project uses have been adapted to Symfony 5.

## Automatic code refactoring - non-essential step

To simplify the process of adapting your code to Symfony 5, you can use [Rector, a reconstructor tool](https://github.com/rectorphp/rector)
that will automatically refactor your Symfony and PHPunit code.

To properly refactor your code, you might need to run the Rector `process` command for each Symfony version from 4.0 to 5.0 in turn:

`vendor/bin/rector process src --set symfony40`

You can find all the available sets in [the Rector repository](https://github.com/rectorphp/rector/tree/v0.7.65/config/set). 
Keep in mind that after automatic refactoring finishes there might be some code chunks that you need to fix manually.
