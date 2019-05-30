# Bundles

## Dealing with bundles

eZ Platform is based on the Symfony 3 framework and applies a similar way of organizing the app. Like in Symfony, where ["everything is a bundle"](http://symfony.com/doc/current/book/bundles.html), your eZ Platform application is going to be a collection of bundles.

### What is a bundle?

A bundle in Symfony (and eZ Platform) is a separate part of your application that implements a feature. You can create bundles yourself or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many eZ Platform functionalities are provided through separate bundles included in the installation. You can see the bundles that are automatically installed with eZ Platform in [composer.json](https://github.com/ezsystems/ezplatform/blob/master/composer.json).

### How to use bundles?

All the bundles containing built-in eZ Platform functionalities are installed automatically.
By default, a clean eZ Platform installation also contains an AppBundle where you can place your custom code.

You can see a list of other available community-developed bundles on <https://ezplatform.com/Bundles>.
Refer to their respective pages for instructions on how to install them.

### How to create bundles?

You can generate a new bundle using a `generate:bundle` command. See [Symfony documentation on generating bundles](http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_bundle.html).

### How to remove a bundle?

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need) see the [How to Remove a Bundle](http://symfony.com/doc/current/bundles/remove.html) instruction in Symfony doc.

## Structuring a bundle

### The AppBundle

Most projects can use the provided `AppBundle`, in the `src` folder. It is enabled by default. The project's PHP code (controllers, event listeners, etc.) can be placed there.

Reusable libraries should be packaged so that they can easily be managed using Composer.

### Templates

Project templates should go into `app/Resources/views`.

They can then be referenced in code without any prefix, for example `app/Resources/views/content/full.html.twig` can be referenced in Twig templates or PHP as `content/full.html.twig`.

### Assets

Project assets should go into the `web` folder.

They can be referenced as relative to the root, for example `web/js/script.js` can be referenced as `js/script.js` from templates.

All project assets are accessible through the `web/assets` path.

??? note "Removing `web/assets` manually"

	If you ever remove the `web/assets` folder manually, you need to dump translations before performing
	the `yarn encore <dev|prod>` command:

	```
	php bin/console bazinga:js-translation:dump web/assets --merge-domains
	```

#### Importing assets from a bundle

eZ Platform uses [Webpack Encore](https://symfony.com/doc/3.4/frontend.html#webpack-encore) for asset management.

##### Configuration from a bundle

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
    see [`ez.config.js`](https://github.com/ezsystems/ezplatform-admin-ui-modules/blob/master/Resources/encore/ez.config.js)

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
    see [`ez.config.manager.js`](https://github.com/ezsystems/ezplatform-matrix-fieldtype/blob/master/src/bundle/Resources/encore/ez.config.manager.js).

To add new configuration under your own namespace and with its own dependencies,
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

##### Configuration from main project files

If you prefer to include the asset configuration in the main project files,
add it in [`webpack.config.js`](https://github.com/ezsystems/ezplatform/blob/master/webpack.config.js#L14).

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

### Configuration

Configuration may go into `app/config`. However, service definitions from `AppBundle` should go into `src/AppBundle/Resources/config`.

### Project example

You can see an example of organizing a simple project in the [companion repository](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial) for the [eZ Enterprise Beginner tutorial](../tutorials/enterprise_beginner/ez_enterprise_beginner_tutorial_-_its_a_dogs_world.md)

### Versioning a project

The recommended method is to version the whole ezplatform repository. Per installation configuration should use `parameters.yml`.

## Built-in bundles

The following tables give an overview of the main eZ Platform bundles.

### Core bundles

|Bundle|Description|
|---------|-----------|
|[ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel)|contains the core of the whole eZ Platform application e.g. EzPublishCoreBundle|
|[repository-forms](https://github.com/ezsystems/repository-forms)|provides form-based interaction for the Repository Value objects|
|[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|[Solr-powered](http://lucene.apache.org/solr/) search handler for eZ Platform|
|[ez-support-tools](https://github.com/ezsystems/ez-support-tools)|provides functionality for system information|
|[ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache)|HTTP cache handling for eZ Platform, using multi tagging (incl Varnish xkey)|
|[ezplatform-admin-ui](https://github.com/ezsystems/ezplatform-admin-ui)|contains Back Office interface for eZ Platform v2+|
|[ezplatform-admin-ui-modules](https://github.com/ezsystems/ezplatform-admin-ui-modules)|re-useable React JavaScript components for eZ Platform v2+ AdminUI|
|[ezplatform-admin-ui-assets](https://github.com/ezsystems/ezplatform-admin-ui-assets)|contains assets for AdminUI|
|[ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|design fallback system for eZ Platform similar to legacy design fallback system|
|[ezplatform-standard-design](https://github.com/ezsystems/ezplatform-standard-design)|defines standard Design and Theme to be handled by ezplatform-design-engine|
|[ezplatform-cron](https://github.com/ezsystems/ezplatform-cron)|exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezplatform:cron:run`|
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|common reusable sentence implementations and other common needs for Behat testing in eZ bundles/projects|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|
    |date-based-publisher|provides the date based publishing functionality for the eZ Studio product|
    |flex-workflow|implementation of a collaboration feature that lets you send content draft to any user for a review or rewriting|
    |ezplatform-page-fieldtype|page handling FieldType for eZ Platform EE 2.2+|
    |ezplatform-page-builder|contains eZ Platform Page editor for eZ Platform EE 2.2+|
    |ezplatform-ee-installer|provides `ezplatform:install` Symfony console command which is the installer for eZ Platform Enterprise v2|
    |ezplatform-http-cache-fastly|extends ezplatform-http-cache to support Fastly, for use on Platform.sh PE or standalone|

### Optional bundles

|Bundle|Description|
|---------|-----------|
|[ezplatform-installer](https://github.com/ezsystems/ezplatform-installer)|package provides `ezplatform:install` Symfony console command which is the installer for eZ Platform v2|
|[ezplatform-i18n](https://github.com/ezsystems/ezplatform-i18n)|centralized internationalization|
|[ezplatform-multi-file-upload](https://github.com/ezsystems/ezplatform-multi-file-upload)|allows uploading multiple files as new content items at once|
|[ezplatform-demo-assets](https://github.com/ezsystems/ezplatform-demo-assets)|contains binary install data for ezsystems/ezplatform-demo|
|[ezplatform-automated-translation](https://github.com/ezsystems/ezplatform-automated-translation)|adds automated translation|
|[EzSystemsPrivacyCookieBundle](https://github.com/ezsystems/EzSystemsPrivacyCookieBundle)|adds privacy cookie banner|
|[ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext)|Field Type for supporting rich formatted text stored in a structured XML format|
|[CommentsBundle](https://github.com/ezsystems/CommentsBundle)|comment bundle for eZ Platform integrating with Disqus and Facebook and allowing custom integrations|
|[EzSystemsRecommendationBundle](https://github.com/ezsystems/EzSystemsRecommendationBundle)|integration of YooChoose, a content recommendation solution|
|[EzSystemsShareButtonsBundle](https://github.com/ezsystems/EzSystemsShareButtonsBundle)|adds social share buttons|
|[RepositoryProfilerBundle](https://github.com/ezsystems/RepositoryProfilerBundle)|profiles Platform API/SPI and sets up scenarios to be able to continuously test to keep track of performance regressions of repository and underlying storage engines|
|[QueryBuilderBundle](https://github.com/ezsystems/QueryBuilderBundle)|provides a PHP API dedicated to fluently writing repository queries|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|   
    |cloud-deployment-manager|dedicated cloud deployment manager|
    |EzLandingPageFieldTypeBundle|Landing Page that is at the heart of StudioUI|
    |ezstudio-demo-bundle|represents a demo front-end website with eZ Studio|
    |ezstudio-personalized-block|eZ Systems Personalized Block Bundle|

### Education

|Bundle|Description|
|------|-----------|
|[CookbookBundle](https://github.com/ezsystems/CookbookBundle)|working examples for using eZ Platform Public API|
|[ezplatform-com](https://github.com/ezsystems/ezplatform-com)|the eZ Systems Developer Hub for the Open Source PHP CMS eZ Platform (example site)|
|[ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)|fork of the "ezplatform-ee" meta repository, contains changes to composer.json, AppKernel.php and config necessary to enable eZ Platform Enterprise Edition Demo. Not recommended for a clean install for new projects, but great for observation and learning (example site)|
|[ezplatform-demo](https://github.com/ezsystems/ezplatform-demo)|fork of "ezplatform" meta repository, contains code and dependencies for demo distribution of eZ Platform. Not recommended for a clean installation for new projects, but great for observation and learning(example site)|
|[TweetFieldTypeBundle](https://github.com/ezsystems/TweetFieldTypeBundle)|bundle that is created in the Field Type Tutorial (example field type)|
|[ezplatform-drawio-fieldtype](https://github.com/ezsystems/ezplatform-drawio-fieldtype)|provides support for diagrams editing in eZ Platform via draw.io (example field type)|
|[ezplatform-ui-2.0-introduction](https://github.com/ezsystems/ezplatform-ui-2.0-introduction)|an example of eZ Platform extensibility in version 2|
|[ezplatform-ee-beginner-tutorial](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial)|resources used in the eZ Platform Enterprise Edition Beginner Tutorial|
|[ExtendingPlatformUIConferenceBundle](https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle)|bundle created in the Extending PlatformUI tutorial|
|[docker-php](https://github.com/ezsystems/docker-php)|contains PHP docker image example|

### Documentation - additional resources

|Repository|Description|
|------|-----------|
|[developer-documentation](https://github.com/ezsystems/developer-documentation)|source for the developer documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP. https://doc.ezplatform.com|
|[user-documentation](https://github.com/ezsystems/user-documentation)|source for the user documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP|
|[ezservices-documentation](https://github.com/ezsystems/ezservices-documentation)|source for the eZ Services documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP|

### Legacy

|Bundle|Description|
|------|-----------|
|[LegacyBridge](https://github.com/ezsystems/LegacyBridge)|optional bridge between eZ Platform and eZ Publish Legacy that simplifies migration to eZ Platform [Community co-maintained]|
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|XmlText field type for eZ Platform [Community co-maintained]|
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio landing page management|
|[ngsymfonytools-bundle](https://github.com/ezsystems/ngsymfonytools-bundle)|integrates the legacy [netgen/ngsymfonytools](https://github.com/netgen/ngsymfonytools) as a Legacy bundle|
|[ezpublish-legacy-installer](https://github.com/ezsystems/ezpublish-legacy-installer)| custom Composer installer for eZ Publish legacy extensions|

## Using third-party bundles

### Overriding bundles

When you use an external bundle, you can override its parts, such as templates, controllers, etc.

To do so, make use of [Symfony's bundle override mechanism](https://symfony.com/doc/3.4/bundles/override.html).

Note that when overriding files, the path inside your application has to correspond to the path inside the bundle.
