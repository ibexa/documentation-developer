# Project organization

eZ Platform is a Symfony application and follows the project structure used by Symfony.

You can see an example of organizing a simple project in the [companion repository](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial/tree/v3-master) for the [eZ Enterprise Beginner tutorial](../tutorials/enterprise_beginner/ez_enterprise_beginner_tutorial_-_its_a_dogs_world.md).

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

eZ Platform uses [Webpack Encore](https://symfony.com/doc/5.0/frontend.html#webpack-encore) for asset management.

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

!!! tip

    The following procedure is applicable to any type of settings supported by Symfony framework.

If you are keeping some of your code in a bundle, dealing with core bundle semantic configuration can be tedious
if you maintain it in the main `config/packages/ezplatform.yaml` configuration file.

You can import configuration from a bundle in two ways: [the manual way](#importing-configuration-manually) and [the implicit way](#importing-configuration-implicitly).

#### Importing configuration manually

Out of the two ways possible, importing configuration manually is the simplest and has the advantage of being explicit.

It relies on using the `imports` statement in your main `config/packages/ezplatform.yaml`.
If you want to import configuration for development use only, you can do so in `config/packages/dev/ezplatform.yaml`.

``` yaml
imports:
    # Import the template selection rules that reside in your custom AcmeExampleBundle.
    - {resource: "@AcmeExampleBundle/Resources/config/templates_rules.yaml"}
 
ezplatform:
    # ...
```

Place the `templates_rules.yaml` in the `Resources/config` folder in `AcmeExampleBundle`.
The configuration tree from this file will be merged with the main one.

``` yaml
ezplatform:
    system:
        <siteaccess>:
            content_view:
                full:
                    article:
                        template: '@AcmeExample/full/article.html.twig'
                        match:
                            Identifier\ContentType: [article]
                    special:
                        template: '@AcmeExample/full/special.html.twig'
                        match:
                            Id\Content: 142
```

!!! caution

    If both cover the same settings, the imported configuration overrides the main configuration files.  

#### Importing configuration implicitly

The following example shows how to implicitly load settings on the example of eZ Platform kernel.
Note that this is also valid for any bundle.

This assumes you are familiar with [service container extensions.](https://symfony.com/doc/5.0/service_container/import.html#importing-configuration-via-container-extensions)

!!! note

    Configuration loaded this way will be overridden by the main `ezplatform.yaml` file.

In `Acme/ExampleBundle/DependencyInjection/AcmeExampleExtension`:

``` php
<?php

namespace Acme\ExampleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/5.0/cookbook/bundles/extension.html}
 */
class AcmeExampleExtension extends Extension implements PrependExtensionInterface
{
    // ...

    /**
     * Allow an extension to prepend the extension configurations.
     * Here we will load our template selection rules.

     *
     * @param ContainerBuilder $container
     */
    public function prepend( ContainerBuilder $container )
    {
        // Loading your YAML file containing template rules
        $configFile = __DIR__ . '/../Resources/config/template_rules.yaml';
        $config = Yaml::parse( file_get_contents( $configFile ) );
        // Explicitly prepend loaded configuration for "ezplatform" namespace.
        // It will be placed under the "ezplatform" configuration key, like in ezplatform.yaml.
        $container->prependExtensionConfig( 'ezplatform', $config );
        $container->addResource( new FileResource( $configFile ) );
    }
}
```

Remember to place your bundle before `EzPlatformCoreBundle` in `bundles.php`.

In `AcmeExampleBundle/Resources/config/template_rules.yaml`:

``` yaml
# You explicitly prepended config for "ezplatform" namespace in the service container extension, 
# so no need to repeat it here
system:
    <siteaccess>:
        content_view:
            full:
                article:
                    template: '@AcmeExample/full/article.html.twig'
                    match:
                        Identifier\ContentType: [article]
                special:
                    template: '@AcmeExample/full/special.html.twig'
                    match:
                        Id\Content: 142
```

Service container extensions are called only when the container is being compiled,
so performance is not affected.

## Versioning a project

The recommended method is to version the whole `ezplatform` repository.
