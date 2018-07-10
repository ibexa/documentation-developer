# Bundles

## Dealing with bundles

eZ Platform is based on the Symfony2 framework and applies a similar way of organizing the app. Like in Symfony, where ["everything is a bundle"](http://symfony.com/doc/current/book/bundles.html), your eZ Platform application is going to be a collection of bundles.

### What is a bundle?

A bundle in Symfony (and eZ Platform) is a separate part of your application that implements a feature. You can create bundles yourself or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many eZ Platform functionalities are provided through separate bundles included in the installation. You can see the bundles that are automatically installed with eZ Platform in [composer.json](https://github.com/ezsystems/ezplatform/blob/master/composer.json).

### How to use bundles?

All the bundles containing built-in eZ Platform functionalities are installed automatically
By default, a clean eZ Platform installation also contains an AppBundle where you can place your custom code.

You can see a list of other available community-developed bundles on <https://ezplatform.com/Bundles>.
Refer to their respective pages for instructions on how to install them.

To learn more about organizing your eZ Platform project, see [Best Practices](best_practices.md).

### How to create bundles?

You can generate a new bundle using a `generate:bundle` command. See [Symfony documentation on generating bundles](http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_bundle.html).

### How to remove bundles?

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need) see the [How to Remove a Bundle](http://symfony.com/doc/current/bundles/remove.html) instruction in Symfony doc.

## Built-in bundles

The following tables give an overview of the main eZ Platform bundles.

### Core bundles

|Bundle|Description|
|---------|-----------|
|[ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel)|contains the core of the whole eZ Platform application e.g. EzPublishCoreBundle|
|[repository-forms](https://github.com/ezsystems/repository-forms)|provides form-based interaction for the Repository Value objects|
|[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|[Solr-powered](http://lucene.apache.org/solr/) search handler for eZ Platform|
|[ez-support-tools](https://github.com/ezsystems/ez-support-tools)|provides functionality for system information|
|[ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|design fallback system for eZ Platform similar to legacy design fallback system|
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|common reusable sentence implementations and other common needs for Behat testing in eZ bundles/projects|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|
    |date-based-publisher|provides the date based publishing functionality for the eZ Studio product|
    |flex-workflow|implementation of a collaboration feature that lets you send content draft to any user for a review or rewriting|

### Optional bundles

|Bundle|Description|
|---------|-----------|
|[ezplatform-i18n](https://github.com/ezsystems/ezplatform-i18n)|centralized internationalization|
|[ezplatform-demo-assets](https://github.com/ezsystems/ezplatform-demo-assets)|contains binary install data for ezsystems/ezplatform-demo|
|[PlatformUIBundle](https://github.com/ezsystems/PlatformUIBundle)|provides the main editing and back-end interface for eZ Platform v1|
|[PlatformUIAssetsBundle](https://github.com/ezsystems/PlatformUIAssetsBundle)|assets for PlatformUIBundle, branches will only contain meta files and config, tags will contain the assets for eZ Platform v1|
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
    |ezstudio-cron|eZ Platform EE 1.x series only - exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezpublish:cron:run`|
    |ez-service-network|provides API's and functionality for license handling and authentication needs|
    |cloud-deployment-manager|dedicated cloud deployment manager|
    |StudioUIBundle|contains the Studio editing interface in eZ Platform v1|
    |ezstudio-form-builder|Form Builder Bundle is a part of eZ Studio and is installed with eZ Studio meta repository in eZ Platform v1|
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
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|XmlText field type for eZ Platform [Community co-maintained]|
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio landing page management|
|[ngsymfonytools-bundle](https://github.com/ezsystems/ngsymfonytools-bundle)|integrates the legacy [netgen/ngsymfonytools](https://github.com/netgen/ngsymfonytools) as a Legacy bundle|
|[ezpublish-legacy-installer](https://github.com/ezsystems/ezpublish-legacy-installer)|A custom Composer installer for eZ Publish legacy extensions|