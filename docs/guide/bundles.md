# Bundles

## What is a bundle?

A bundle in Symfony (and eZ Platform) is a separate part of your application that implements a feature. You can create bundles yourself or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many eZ Platform functionalities are provided through separate bundles included in the installation. You can see the bundles that are automatically installed with eZ Platform in [composer.json](https://github.com/ezsystems/ezplatform/blob/master/composer.json).

## How to use bundles?

All the bundles containing built-in eZ Platform functionalities are installed automatically.

You can see a list of other available community-developed bundles on <https://ezplatform.com/Bundles>.
Refer to their respective pages for instructions on how to install them.

## How to create bundles?

See [Symfony documentation on bundles](https://symfony.com/doc/5.0/bundles.html) to learn how to structure your bundle.

## How to remove a bundle?

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need) see the [How to Remove a Bundle](http://symfony.com/doc/5.0/bundles/remove.html) instruction in Symfony doc.

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
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|common reusable sentence implementations and other common needs for Behat testing in eZ bundles/projects|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|
    |date-based-publisher|provides the date based publishing functionality for the eZ Studio product|
    |ezplatform-workflow|implementation of a collaboration feature that lets you send content draft to any user for a review or rewriting|
    |ezplatform-page-fieldtype|page handling Field Type for eZ Platform EE 2.2+|
    |ezplatform-page-builder|contains eZ Platform Page editor for eZ Platform EE 2.2+|
    |ezplatform-ee-installer|provides `ezplatform:install` Symfony console command which is the installer for eZ Platform Enterprise v2|
    |ezplatform-http-cache-fastly|extends ezplatform-http-cache to support Fastly, for use on Platform.sh PE or standalone|
    |ezplatform-calendar|extends the Back Office by adding the calendar tab with the calendar widget|
    |ezplatform-version-comparison|allows comparing between two versions of the same Field|

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
|[ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)|fork of the "ezplatform-ee" meta repository, contains changes necessary to enable eZ Platform Enterprise Edition Demo. Not recommended for a clean install for new projects, but great for observation and learning (example site)|
|[ezplatform-demo](https://github.com/ezsystems/ezplatform-demo)|fork of "ezplatform" meta repository, contains code and dependencies for demo distribution of eZ Platform. Not recommended for a clean installation for new projects, but great for observation and learning(example site)|
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
|[ezpersonalization-documentation](https://github.com/ezsystems/ezservices-documentation)|source for the eZ Personalization documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP|

### Legacy

|Bundle|Description|
|------|-----------|
|[LegacyBridge](https://github.com/ezsystems/LegacyBridge)|optional bridge between eZ Platform and eZ Publish Legacy that simplifies migration to eZ Platform [Community co-maintained]|
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|XmlText field type for eZ Platform [Community co-maintained]|
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio landing page management|
|[ngsymfonytools-bundle](https://github.com/ezsystems/ngsymfonytools-bundle)|integrates the legacy [netgen/ngsymfonytools](https://github.com/netgen/ngsymfonytools) as a Legacy bundle|
|[ezpublish-legacy-installer](https://github.com/ezsystems/ezpublish-legacy-installer)| custom Composer installer for eZ Publish legacy extensions|

## Third-party bundles

### Overriding bundles

When you use an external bundle, you can override its parts, such as templates, controllers, etc.

To do so, make use of [Symfony's bundle override mechanism](https://symfony.com/doc/5.0/bundles/override.html).

Note that when overriding files, the path inside your application has to correspond to the path inside the bundle.
