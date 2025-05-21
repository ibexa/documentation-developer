---
description: Import assets, such as stylesheets or images, from a separate bundle with customizations.
---

# Importing assets from a bundle

[[= product_name =]] uses [Webpack Encore]([[= symfony_doc =]]/frontend.html#webpack-encore) for asset management.

## Configuration from a bundle

To import assets from a bundle, configure them in an `ibexa.config.js` file that you create either in the bundle's `Resources/encore/` folder, or in the `encore` folder in the root directory of your project:

``` js
const path = require('path');

module.exports = (Encore) => {
	Encore.addEntry('<entry-name>', [
		path.resolve(__dirname, '<path_to_file>'),
    ]);
};
```

Use `<entry-name>` to refer to this configuration entry from Twig templates:

`{{ encore_entry_script_tags('<entry-name>', null, 'ibexa') }}`

To import CSS files only, use:

`{{ encore_entry_link_tags('<entry-name>', null, 'ibexa') }}`

!!! tip

    After you add new files, run `php bin/console cache:clear`.

    For a full example of importing asset configuration, see [`ibexa.config.js`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/encore/ibexa.config.js)

To edit existing configuration entries, either in the bundle's `Resources/encore/` folder, or in the `encore` folder in the root folder of your project, create an `ibexa.config.manager.js` file:

``` js
const path = require('path');

module.exports = (ibexaConfig, ibexaConfigManager) => {
	ibexaConfigManager.replace({
	    ibexaConfig,
	    entryName: '<entry-name>',
	    itemToReplace: path.resolve(__dirname, '<path_to_old_file>'),
	    newItem: path.resolve(__dirname, '<path_to_new_file>'),
	});
	ibexaConfigManager.remove({
	    ibexaConfig,
	    entryName: '<entry-name>',
	    itemsToRemove: [
	        path.resolve(__dirname, '<path_to_old_file>'),
	        path.resolve(__dirname, '<path_to_old_file>'),
	    ],
	});
	ibexaConfigManager.add({
	    ibexaConfig,
	    entryName: '<entry-name>',
	    newItems: [
	        path.resolve(__dirname, '<path_to_new_file>'),
	        path.resolve(__dirname, '<path_to_new_file>'),
	    ],
	});
};
```

!!! tip

	If you don't know what `entryName` to use, you can use the browser's developer tools to check what files are loaded on the given page.
	Then, use the file name as `entryName`.

!!! tip

    After you add new files, run `php bin/console cache:clear`.

    For a full example of overriding configuration, see [`ibexa.config.manager.js`](https://github.com/ibexa/fieldtype-matrix/blob/4.6/src/bundle/Resources/encore/ibexa.config.manager.js).

To add a new configuration under your own namespace and with its own dependencies, create an `ibexa.webpack.custom.config.js` file that you create either in the bundle's `Resources/encore/` folder, or in the `encore` folder in the root directory of your project, for example:

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

    If you don't plan to add multiple entry files on the same page in your custom configuration, use the `disableSingleRuntimeChunk()` function to avoid adding a separate `runtime.js` file.
    Otherwise, your JS code may be run multiple times.
    By default, the `enableSingleRuntimeChunk()` function is used.

## Configuration from main project files

If you prefer to include the asset configuration in the main project files, add it in [`webpack.config.js`](https://github.com/ibexa/recipes/blob/master/ibexa/oss/4.0/encore/webpack.config.js#L31).

To overwrite the built-in assets, use the following configuration to replace, remove, or add asset files in `webpack.config.js`:

``` js
ibexaConfigManager.replace({
    ibexaConfig,
    entryName: '<entry-name>',
    itemToReplace: path.resolve(__dirname, '<path_to_old_file>'),
    newItem: path.resolve(__dirname, '<path_to_new_file>'),
});

ibexaConfigManager.remove({
    ibexaConfig,
    entryName: '<entry-name>',
    itemsToRemove: [
        path.resolve(__dirname, '<path_to_old_file>'),
        path.resolve(__dirname, '<path_to_old_file>'),
    ],
});

ibexaConfigManager.add({
    ibexaConfig,
    entryName: '<entry-name>',
    newItems: [
        path.resolve(__dirname, '<path_to_new_file>'),
        path.resolve(__dirname, '<path_to_new_file>'),
    ],
});
```
