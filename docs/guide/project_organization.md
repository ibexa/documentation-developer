# Project organization

[[= product_name =]] is a Symfony application and follows the project structure used by Symfony.

You can see an example of organizing a simple project in the [companion repository](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial/tree/v3-master) for the [[[= product_name_exp =]] Beginner tutorial](../tutorials/enterprise_beginner/ez_enterprise_beginner_tutorial_-_its_a_dogs_world.md).

## PHP code

The project's PHP code (controllers, event listeners, etc.) should be placed in the `src` folder.

Reusable libraries should be packaged so that they can easily be managed using Composer.

## Templates

Project templates should go into the `templates` folder.

They can then be referenced in code without any prefix, for example `templates/full/article.html.twig` can be referenced in Twig templates or PHP as `full/article.html.twig`.

## Assets

Project assets should go into the `assets` folder.

They can be referenced as relative to the root, for example `assets/js/script.js` can be referenced as `js/script.js` from templates.

All project assets are accessible through the `assets` path.

??? note "Removing `assets` manually"

    If you ever remove the `assets` folder manually, you need to dump translations before performing
    the `yarn encore <dev|prod>` command:
    
    ```
    php bin/console bazinga:js-translation:dump assets --merge-domains
    ```

### Importing assets from a bundle

[[= product_name =]] uses [Webpack Encore](https://symfony.com/doc/5.0/frontend.html#webpack-encore) for asset management.

#### Configuration from a bundle

To import assets from a bundle, you need to configure them in the bundle's `Resources/encore/ez.config.js`:

``` js
const path = require('path');

module.exports = (Encore) => {
	Encore.addEntry('<entry-name>', [
		path.resolve(__dirname, '<path_to_file>'),
    ]);
};
```

Use `<entry-name>` to refer to this configuration entry from Twig templates:

`{{ encore_entry_script_tags('<entry-name>', null, 'ezplatform') }}`

To import CSS files only, use:

`{{ encore_entry_link_tags('<entry-name>', null, 'ezplatform') }}`

!!! tip

    After adding new files, run `php bin/console cache:clear`.

    For a full example of importing asset configuration,
    see [`ez.config.js`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v2.0.2/src/bundle/Resources/encore/ez.config.js)

To edit existing configuration entries, create a `Resources/encore/ez.config.manager.js` file:

``` js
const path = require('path');

module.exports = (eZConfig, eZConfigManager) => {
	eZConfigManager.replace({
	    eZConfig,
	    entryName: '<entry-name>',
	    itemToReplace: path.resolve(__dirname, '<path_to_old_file>'),
	    newItem: path.resolve(__dirname, '<path_to_new_file>'),
	});
	eZConfigManager.remove({
	    eZConfig,
	    entryName: '<entry-name>',
	    itemsToRemove: [
	        path.resolve(__dirname, '<path_to_old_file>'),
	        path.resolve(__dirname, '<path_to_old_file>'),
	    ],
	});
	eZConfigManager.add({
	    eZConfig,
	    entryName: '<entry-name>',
	    newItems: [
	        path.resolve(__dirname, '<path_to_new_file>'),
	        path.resolve(__dirname, '<path_to_new_file>'),
	    ],
	});
};
```

!!! tip

	If you do not know what `entryName` to use, you can check the dev tools for files that are loaded on the given page.
	Use the file name as `entryName`.

!!! tip

    After adding new files, run `php bin/console cache:clear`.

    For a full example of overriding configuration,
    see [`ez.config.manager.js`](https://github.com/ezsystems/ezplatform-matrix-fieldtype/blob/v2.0.0/src/bundle/Resources/encore/ez.config.manager.js).

To add a new configuration under your own namespace and with its own dependencies,
add a `Resources/encore/ez.webpack.custom.config.js` file, for example:

``` js
	const Encore = require('@symfony/webpack-encore');

	Encore.setOutputPath('<custom-path>')
	    .setPublicPath('<custom-path>')
	    .addExternals('<custom-externals>')
	    // ...
	    .addEntry('<entry-name>', ['<JS-path>']);

	const customConfig = Encore.getWebpackConfig();

	customConfig.name = 'customConfigName';

	// Config or array of configs: [customConfig1, customConfig2];
	module.exports = customConfig;
```

!!! tip

    If you don't plan to add multiple entry files on the same page in your custom config,
    use the `disableSingleRuntimeChunk()` funtion to avoid adding a separate `runtime.js` file.
    Otherwise, your JS code may be run multiple times.
    By default, the `enableSingleRuntimeChunk()` function is used.

#### Configuration from main project files

If you prefer to include the asset configuration in the main project files,
add it in [`webpack.config.js`](https://github.com/ezsystems/ezplatform/blob/v3.0.3/webpack.config.js#L15).

To overwrite built-in assets, use the following configuration to replace, remove or add asset files
in `webpack.config.js`:

``` js
eZConfigManager.replace({
    eZConfig,
    entryName: '<entry-name>',
    itemToReplace: path.resolve(__dirname, '<path_to_old_file>'),
    newItem: path.resolve(__dirname, '<path_to_new_file>'),
});

eZConfigManager.remove({
    eZConfig,
    entryName: '<entry-name>',
    itemsToRemove: [
        path.resolve(__dirname, '<path_to_old_file>'),
        path.resolve(__dirname, '<path_to_old_file>'),
    ],
});

eZConfigManager.add({
    eZConfig,
    entryName: '<entry-name>',
    newItems: [
        path.resolve(__dirname, '<path_to_new_file>'),
        path.resolve(__dirname, '<path_to_new_file>'),
    ],
});
```

## Configuration

You project's configuration is placed in the respective files in `config/packages`.
See [Configuration](configuration.md) for more information.

### Importing configuration from a bundle

If you are keeping some of your code in a bundle, dealing with core bundle semantic configuration can be tedious
if you maintain it in the main `config/packages/ezplatform.yaml` configuration file.

You can import configuration from a bundle by following the Symfony tutorial [How to Import Configuration Files/Resources](https://symfony.com/doc/5.0/service_container/import.html).

## Versioning a project

The recommended method is to version the whole `ezplatform` repository.
