# Bundles

A bundle in Symfony (and eZ Platform) is a separate part of your application that implements a feature.
You can create bundles yourself or make use of available open-source bundles.
You can also reuse the bundles you create in other projects or share them with the community.

Many eZ Platform functionalities are provided through separate bundles included in the installation.
You can see the bundles that are automatically installed with eZ Platform in [composer.json](https://github.com/ezsystems/ezplatform/blob/3.0/composer.json).

## Working with bundles

All bundles containing built-in eZ Platform functionalities are installed automatically.
Additionally, you can install community-developed bundles from [eZ Platform Packages.](https://ezplatform.com/packages)

To learn how to create your own bundles, see [Symfony documentation on bundles.](https://symfony.com/doc/5.0/bundles.html)

### Overriding third-party bundles

When you use an external bundle, you can override its parts, such as templates, controllers, etc.
To do so, make use of [Symfony's bundle override mechanism](https://symfony.com/doc/5.0/bundles/override.html).
Note that when overriding files, the path inside your application has to correspond to the path inside the bundle.

### Removing bundles

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need),
see the [How to Remove a Bundle](http://symfony.com/doc/5.0/bundles/remove.html) instruction in Symfony doc.

## Built-in bundles

The following tables give an overview of the main eZ Platform bundles.

### Core bundles

|Bundle|Description|
|---------|-----------|
|[ezplatform-kernel](https://github.com/ezsystems/ezplatform-kernel)|contains the core of the whole eZ Platform application e.g. EzPublishCoreBundle|
|[ezplatform-content-forms](https://github.com/ezsystems/ezplatform-content-forms)|provides form-based integration for the Symfony Forms into Content and User objects in kernel|
|[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|[Solr-powered](http://lucene.apache.org/solr/) search handler for eZ Platform|
|[ez-support-tools](https://github.com/ezsystems/ez-support-tools)|provides functionality for system information|
|[ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache)|HTTP cache handling for eZ Platform, using multi tagging (incl Varnish xkey)|
|[ezplatform-admin-ui](https://github.com/ezsystems/ezplatform-admin-ui)|contains Back Office interface for eZ Platform v2+|
|[ezplatform-admin-ui-assets](https://github.com/ezsystems/ezplatform-admin-ui-assets)|contains assets for AdminUI|
|[ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|design fallback system for eZ Platform similar to legacy design fallback system|
|[ezplatform-standard-design](https://github.com/ezsystems/ezplatform-standard-design)|defines standard Design and Theme to be handled by ezplatform-design-engine|
|[ezplatform-cron](https://github.com/ezsystems/ezplatform-cron)|exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezplatform:cron:run`|
|[ezplatform-graphql](https://github.com/ezsystems/ezplatform-graphql)|defines GraphQL server for eZ Platform|
|[ezplatform-matrix-fieldtype](https://github.com/ezsystems/ezplatform-matrix-fieldtype)|dedicated to Matrix Field Type for eZ Platform, it replaces previous version found on `ezcommunity/EzMatrixFieldTypeBundle`|
|[ezplatform-query-fieldtype](https://github.com/ezsystems/ezplatform-query-fieldtype)|Field Type that lists Content items based by querying the Repository|
|[ezplatform-rest](https://github.com/ezsystems/ezplatform-rest)|contains REST API|
|[ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext)|Field Type for supporting rich formatted text stored in a structured XML format|
|[ezplatform-user](https://github.com/ezsystems/ezplatform-user)|dedicated to eZ Platform User management.|
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|common reusable sentence implementations and other common needs for Behat testing in eZ bundles/projects|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|
    |date-based-publisher|provides the date based publishing functionality for the eZ Studio product|
    |ezplatform-workflow|implementation of a collaboration feature that lets you send content draft to any user for a review or rewriting|
    |ezplatform-page-fieldtype|Page handling Field Type|
    |ezplatform-page-builder|contains eZ Platform Page editor|
    |ezplatform-ee-installer|provides `ezplatform:install` Symfony console command which is the installer for eZ Platform Enterprise v2|
    |ezplatform-http-cache-fastly|extends ezplatform-http-cache to support Fastly, for use on Platform.sh PE or standalone|
    |ezplatform-calendar|extends the Back Office by adding the calendar tab with the calendar widget|
    |ezplatform-version-comparison|allows comparing between two versions of the same Field|
    |ezplatform-form-builder|enables creating Form Content items with multiple form fields|
    |ezplatform-site-factory|enables configuration of sites from UI|

### Optional bundles

|Bundle|Description|
|---------|-----------|
|[ezplatform-i18n](https://github.com/ezsystems/ezplatform-i18n)|centralized internationalization|
|[ezplatform-multi-file-upload](https://github.com/ezsystems/ezplatform-multi-file-upload)|allows uploading multiple files as new content items at once|
|[ezplatform-demo-assets](https://github.com/ezsystems/ezplatform-demo-assets)|contains binary install data for ezsystems/ezplatform-demo|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|   
    |ezstudio-personalized-block|eZ Systems Personalized Block Bundle|

### Education

|Bundle|Description|
|------|-----------|
|[ezplatform-com](https://github.com/ezsystems/ezplatform-com)|the eZ Systems Developer Hub for the Open Source PHP CMS eZ Platform (example site)|
|[ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)|fork of the "ezplatform-ee" meta repository, contains changes necessary to enable eZ Platform Enterprise Edition Demo. Not recommended for a clean install for new projects, but great for observation and learning (example site)|
|[ezplatform-ee-beginner-tutorial](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial)|resources used in the eZ Platform Enterprise Edition Beginner Tutorial|
|[docker-php](https://github.com/ezsystems/docker-php)|contains PHP docker image example|

### Documentation - additional resources

|Repository|Description|
|------|-----------|
|[developer-documentation](https://github.com/ezsystems/developer-documentation)|source for the developer documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP. https://doc.ezplatform.com|
|[user-documentation](https://github.com/ezsystems/user-documentation)|source for the user documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP|
|[ezpersonalization-documentation](https://github.com/ezsystems/ezservices-documentation)|source for the eZ Personalization documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP|
