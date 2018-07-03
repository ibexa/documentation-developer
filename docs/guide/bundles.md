# Bundles

## Dealing with bundles

eZ Platform is based on the Symfony2 framework and applies a similar way of organizing the app. Like in Symfony, where ["everything is a bundle"](http://symfony.com/doc/current/book/bundles.html), your eZ Platform application is going to be a collection of bundles.

### What is a bundle?

A bundle in Symfony (and eZ Platform) is a separate part of your application that implements a feature. You can create bundles yourself or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many eZ Platform functionalities are provided through separate bundles included in the installation.

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

The eZ Platform root directory contains multiple sub-directories.
Each sub-directory is dedicated to a specific part of the system and contains a collection of logically related files.
The following table gives an overview of the main eZ Platform directories.

Some of the key built-in bundles are:

**EzPublishCoreBundle**

EzPublishCoreBundle is contained in [ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel).

To get an overview of EzPublishCoreBundle's configuration, run the following command-line script:

``` bash
php app/console config:dump-reference ezpublish
```

**Repository Forms**

[Repository Forms](http://github.com/ezsystems/repository-forms) is a bundle which provides form-based interaction for the Repository Value objects.

It is currently used by:

- `ezsystems/platform-ui-bundle` for most management interfaces: Sections, Content Types, Roles, Policies, etc.
- `ezsystems/ezpublish-kernel` for user registration and user generated content

!!! tip

    You can see the bundles that are automatically installed with eZ Platform in [composer.json](https://github.com/ezsystems/ezplatform/blob/master/composer.json).

### Core bundles

|Bundle|Description|
|---------|-----------|
|[ezplatform](https://github.com/ezsystems/ezplatform)|meta repository that pulls in all dependencies for clean distribution of eZ Platform|
|[ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel)|contains the core of the whole eZ Platform application|
|[repository-forms](https://github.com/ezsystems/repository-forms)|provides form-based interaction for the Repository Value objects|
|[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|[Solr-powered](http://lucene.apache.org/solr/) search handler for eZ Platform|
|[ez-support-tools](https://github.com/ezsystems/ez-support-tools)|provides functionality for system information|
|[ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache)|HTTP cache handling for eZ Platform, using multi tagging (incl Varnish xkey)|
|[ezplatform-admin-ui](https://github.com/ezsystems/ezplatform-admin-ui)|contains Back Office interface for eZ Platform v2+|
|[ezplatform-admin-ui-modules](https://github.com/ezsystems/ezplatform-admin-ui-modules)|re-useable React JavaScript components for eZ Platform AdminUI|
|[ezplatform-admin-ui-assets](https://github.com/ezsystems/ezplatform-admin-ui-assets)|contains assets for AdminUI|
|[ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|design fallback system for eZ Platform similar to legacy design fallback system|
|[ezplatform-standard-design](https://github.com/ezsystems/ezplatform-standard-design)|defines standard Design and Theme to be handled by ezplatform-design-engine|
|[ezplatform-cron](https://github.com/ezsystems/ezplatform-cron)|exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezplatform:cron:run`|
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|common reusable sentance implementations and other common needs for Behat testing in eZ bundles/projects|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|
    |[ezplatform-ee](https://github.com/ezsystems/ezplatform-ee)|fork of the "ezplatform" meta repository, contains changes to composer.json that pull in all dependencies from updates.ez.no for eZ Platform Enterprise Edition (a commercial distribution of eZ Platform with additional features)|
    |[ezpublish-kernel-ee](https://github.com/ezsystems/ezpublish-kernel-ee)|kernel for enterprise, difference is the stable branches, master is automatically synced|
    |[date-based-publisher](https://github.com/ezsystems/date-based-publisher)|provides the date based publishing functionality for the eZ Studio product|
    |[flex-workflow](https://github.com/ezsystems/flex-workflow)|implementation of a collaboration feature that lets you send content draft to any user for a review or rewriting|
    |[ezplatform-page-fieldtype](https://github.com/ezsystems/ezplatform-page-fieldtype)|page handling FieldType for eZ Platform EE 2.2+|
    |[ezplatform-page-builder](https://github.com/ezsystems/ezplatform-page-builder)|contains eZ Platform Page editor for eZ Platform EE 2.2+|
    |[ezplatform-ee-installer](https://github.com/ezsystems/ezplatform-ee-installer)|provides `ezplatform:install` Symfony console command which is the installer for eZ Platform Enterprise v2|
    |[ezplatform-http-cache-fastly](https://github.com/ezsystems/ezplatform-http-cache-fastly)|extends ezplatform-http-cache to support Fastly, for use on Platform.sh PE or standalone|

### Platform usage

|Bundle|Description|
|---------|-----------|
|[ezplatform-installer](https://github.com/ezsystems/ezplatform-installer)|package provides `ezplatform:install` Symfony console command which is the installer for eZ Platform v2|
|[ez-js-rest-client](https://github.com/ezsystems/ez-js-rest-client)|JavaScript REST client for eZ Platform RESTv2 API, mimics PHP API found in eZ Platform|
|[ezplatform-i18n](https://github.com/ezsystems/ezplatform-i18n)|centralized internationalization|
|[launchpad](https://github.com/ezsystems/launchpad)|CLI tool to bootstrap an eZ Platform project Docker stack|
|[ezplatform-multi-file-upload](https://github.com/ezsystems/ezplatform-multi-file-upload)|allows uploading multiple files as new content items at once|
|[satis](https://github.com/ezsystems/satis)|simple static Composer repository generator|
|[ezplatform-demo-assets](https://github.com/ezsystems/ezplatform-demo-assets)|contains binary install data for ezsystems/ezplatform-demo|
|[requirements](https://github.com/ezsystems/requirements)|requirements repository for eZ Platform development|
|[ezcs](https://github.com/ezsystems/ezcs)|configuration for various tools to check the eZ coding standards in different languages|
|[ui-guidelines](https://github.com/ezsystems/ui-guidelines)|resource for designers, product managers, and developers, providing a unified language to build and customize eZ Platform admin user interface (aka Platform UI)|
|[PlatformUIBundle](https://github.com/ezsystems/PlatformUIBundle)|provides the main editing and back-end interface for eZ Platform|
|[PlatformUIAssetsBundle](https://github.com/ezsystems/PlatformUIAssetsBundle)|assets for PlatformUIBundle, branches will only contain meta files and config, tags will contain the assets|
|[ezplatform-automated-translation](https://github.com/ezsystems/ezplatform-automated-translation)|adds automated translation|
|[EzSystemsPrivacyCookieBundle](https://github.com/ezsystems/EzSystemsPrivacyCookieBundle)|adds privacy cookie banner|
|[ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext)|Field Type for supporting rich formatted text stored in a structured XML format|
|[CommentsBundle](https://github.com/ezsystems/CommentsBundle)|comment bundle for eZ Platform integrating with Disqus and Facebook and allowing custom integrations|
|[EzSystemsRecommendationBundle](https://github.com/ezsystems/EzSystemsRecommendationBundle)|integration of YooChoose, a content recommendation solution|
|[EzSystemsShareButtonsBundle](https://github.com/ezsystems/EzSystemsShareButtonsBundle)|adds social share buttons|
|[RepositoryProfilerBundle](https://github.com/ezsystems/RepositoryProfilerBundle)|profiles Platform API/SPI and sets up scenarios to be able to continuously test to keep track of performance regressions of repository and underlying storage engines|
|[QueryBuilderBundle](https://github.com/ezsystems/QueryBuilderBundle)|provides a PHP API dedicated to fluently writing repository queries|
|[ezstudio-upgrade](https://github.com/ezsystems/ezstudio-upgrade)|helps upgrade from eZ Platform to the eZ Studio product in an automated way|
|[alloy-editor](https://github.com/ezsystems/alloy-editor)|WYSIWYG editor built on top of CKEditor, designed to create modern web content|
|[demobundle-data](https://github.com/ezsystems/demobundle-data)|binary install data for ezsystems/demobundle|
|[ezmbpaex](https://github.com/ezsystems/ezmbpaex)|functionality for password expiration and validation|
|[ezphttprequest](https://github.com/ezsystems/ezphttprequest)|ezpHttpRequest, a child class of HttpRequest, provided by the PECL package|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|   
    |[ezstudio-cron](https://github.com/ezsystems/ezstudio-cron)|eZ Platform EE 1.x series only - exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezpublish:cron:run`|
    |[ez-service-network](https://github.com/ezsystems/ez-service-network)|provides API's and functionality for license handling and authentication needs|
    |[cloud-deployment-manager](https://github.com/ezsystems/cloud-deployment-manager)|dedicated cloud deployment manager|
    |[StudioUIBundle](https://github.com/ezsystems/StudioUIBundle)|contains the Studio editing interface|
    |[ezstudio-form-builder](https://github.com/ezsystems/ezstudio-form-builder)|Form Builder Bundle is a part of eZ Studio and is installed with eZ Studio meta repository|
    |[EzLandingPageFieldTypeBundle](https://github.com/ezsystems/EzLandingPageFieldTypeBundle)|Landing Page FieldType|
    |[ezstudio-demo-bundle](https://github.com/ezsystems/ezstudio-demo-bundle)|Landing Page that is at the heart of StudioUI|
    |[ezstudio-personalized-block](https://github.com/ezsystems/ezstudio-personalized-block)|eZ Systems Personalized Block Bundle|
    |[ezrecommendation](https://github.com/ezsystems/ezrecommendation)|allows customizing and personalizing your online portal individually for each end user|
    |[ezmemcachedcluster](https://github.com/ezsystems/ezmemcachedcluster)|adds cluster events support with Memcached backend server|

### Legacy

|Bundle|Description|
|------|-----------|
|[LegacyBridge](https://github.com/ezsystems/LegacyBridge)|optional bridge between eZ Platform and eZ Publish Legacy that simplifies migration to eZ Platform [Community co-maintained]|
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|XmlText field type for eZ Platform [Community co-maintained]|
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio landing page management|
|[ngsymfonytools-bundle](https://github.com/ezsystems/ngsymfonytools-bundle)|integrates the legacy [netgen/ngsymfonytools](https://github.com/netgen/ngsymfonytools) as a Legacy bundle|
|[ezpublish-legacy-installer](https://github.com/ezsystems/ezpublish-legacy-installer)|A custom Composer installer for eZ Publish legacy extensions|

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
|[bikeride](https://github.com/ezsystems/bikeride)|beginner tutorial for eZ Platform|
|[ez-beginner-tutorial](https://github.com/ezsystems/ez-beginner-tutorial)|files related to the eZ Platform Beginner Tutorial|
|[ezplatform-ee-beginner-tutorial](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial)|resources used in the eZ Platform Enterprise Edition Beginner Tutorial|
|[ExtendingPlatformUIConferenceBundle](https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle)|bundle created in the Extending PlatformUI tutorial|
|[docker-php](https://github.com/ezsystems/docker-php)|contains PHP docker image example|

### Documentation

|Bundle|Description|
|------|-----------|
|[developer-documentation](https://github.com/ezsystems/developer-documentation)|source for the developer documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP. https://doc.ezplatform.com|
|[user-documentation](https://github.com/ezsystems/user-documentation)|source for the user documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP|
|[ezservices-documentation](https://github.com/ezsystems/ezservices-documentation)|source for the eZ Services documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP|

### Basic directories - READ ONLY

|Bundle|Description|
|---------|-----------|
|[ezpublish-api](https://github.com/ezsystems/ezpublish-api)|subtree split of the eZ Publish 5 (ezsystems/ezpublish-kernel) API interfaces and domain objects|
|[ezpublish-spi](https://github.com/ezsystems/ezpublish-spi)|subtree split of the eZ Publish 5 (ezsystems/ezpublish-kernel) SPI (persistence) interfaces|
|[ezwt-ls-extension](https://github.com/ezsystems/ezwt-ls-extension)|subtree split from ezsystems/ezwt, for use via Composer|
|[ezwebin-ls-extension](https://github.com/ezsystems/ezwebin-ls-extension)|subtree split from ezsystems/ezwebin, for use via Composer|
|[ezstarrating-ls-extension](https://github.com/ezsystems/ezstarrating-ls-extension)|subtree split from ezsystems/ezstarrating, for use via Composer|
|[ezgmaplocation-ls-extension](https://github.com/ezsystems/ezgmaplocation-ls-extension)|subtree split from ezsystems/ezgmaplocation, for use via Composer|
|[ezdemo-ls-extension](https://github.com/ezsystems/ezdemo-ls-extension)|subtree split from ezsystems/ezdemo, for use via Composer|
|[ezflow-ls-extension](https://github.com/ezsystems/ezflow-ls-extension)|subtree split from ezsystems/ezflow, for use via Composer|
|[ezcomments-ls-extension](https://github.com/ezsystems/ezcomments-ls-extension)|subtree split of legacy ezcomments extension, for use via Composer|