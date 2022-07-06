---
description: Import assets, such as stylesheets or images, from a separate bundle with customizations.
---

# Importing assets from a bundle

[[= product_name =]] uses [Webpack Encore]([[= symfony_doc =]]/frontend.html#webpack-encore) for asset management.

## Configuration from a bundle

To import assets from a bundle, you must configure them in the bundle's `Resources/encore/ez.config.js` file:

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

    After you add new files, run `php bin/console cache:clear`.

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

	If you do not know what `entryName` to use, you can use the browser's developer tools to check what files are loaded on the given page.
	Then, use the file name as `entryName`.

!!! tip

    After you add new files, run `php bin/console cache:clear`.

    For a full example of overriding configuration,
    see [`ez.config.manager.js`](https://github.com/ezsystems/ezplatform-matrix-fieldtype/blob/v2.0.0/src/bundle/Resources/encore/ez.config.manager.js).

To add a new configuration under your own namespace and with its own dependencies,
add the `Resources/encore/ez.webpack.custom.config.js` file, for example:

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

    If you don't plan to add multiple entry files on the same page in your custom configuration,
    use the `disableSingleRuntimeChunk()` function to avoid adding a separate `runtime.js` file.
    Otherwise, your JS code may be run multiple times.
    By default, the `enableSingleRuntimeChunk()` function is used.

## Configuration from main project files

If you prefer to include the asset configuration in the main project files,
add it in [`webpack.config.js`](https://github.com/ezsystems/ezplatform/blob/v3.0.3/webpack.config.js#L15).

To overwrite the built-in assets, use the following configuration to replace, remove or add asset files
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
