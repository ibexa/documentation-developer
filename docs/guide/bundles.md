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
|[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|is the [Solr-powered](http://lucene.apache.org/solr/) search handler for eZ Platform|
|[ez-support-tools](https://github.com/ezsystems/ez-support-tools)|provides functionality for system information and in the future tools for identifying issues|
|[ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache)|HTTP cache handling for eZ Platform, using multi tagging (incl Varnish xkey)|
|[ezplatform-admin-ui](https://github.com/ezsystems/ezplatform-admin-ui)|Admin UI for eZ Platform v2+.|
|[ezplatform-admin-ui-modules](https://github.com/ezsystems/ezplatform-admin-ui-modules)|re-useable React JS components for eZ Platform Admin UI|
|[ezplatform-admin-ui-assets](https://github.com/ezsystems/ezplatform-admin-ui-assets)|eZ Platform Admin UI Assets Bundle|
|[ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|design fallback system for eZ Platform similar to legacy design fallback system. Lets you define fallback order for templates and assets.|
|[ezplatform-standard-design](https://github.com/ezsystems/ezplatform-standard-design)|defines standard Design and Theme to be handled by ezplatform-design-engine|
|[ezplatform-cron](https://github.com/ezsystems/ezplatform-cron)|exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezplatform:cron:run`|
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|common reusable sentance implementations and other common needs for Behat testing in eZ bundles/projects|

!!! Enterprise

    |Bundle|Description|
    |---------|-----------|
    |[ezplatform-ee](https://github.com/ezsystems/ezplatform-ee)|fork of the "ezplatform" meta repository, contains changes to composer.json that pull in all dependencies from updates.ez.no for eZ Platform Enterprise Edition (a commercial distribution of eZ Platform with additional features)|
    |[date-based-publisher](https://github.com/ezsystems/date-based-publisher)|provides the date based publishing functionality for the eZ Studio product|
    |[flex-workflow](https://github.com/ezsystems/flex-workflow)|Flex Workflow Implementation|
    |[ezplatform-page-fieldtype](https://github.com/ezsystems/ezplatform-page-fieldtype)|page handling FieldType for eZ Platform EE 2.2+|
    |[ezplatform-page-builder](https://github.com/ezsystems/ezplatform-page-builder)|eZ Platform Page Builder Bundle|
    |[ezplatform-ee-installer](https://github.com/ezsystems/ezplatform-ee-installer)|provides `ezplatform:install` Symfony console command which is the installer for eZ Platform Enterprise v2|
    |[ezplatform-http-cache-fastly](https://github.com/ezsystems/ezplatform-http-cache-fastly)|eZ Platform Enterprise Bundle extending ezplatform-http-cache to support Fastly, for use on Platform.sh PE or standalone|

### Platform usage

|Bundle|Description|
|---------|-----------|
|[ez-js-rest-client](https://github.com/ezsystems/ez-js-rest-client)|JavaScript REST client for eZ Platform RESTv2 API, mimics PHP API found in eZ Platform|
|[ezplatform-i18n](https://github.com/ezsystems/ezplatform-i18n)|Centralized internationalization of eZ Platform, the open-source Symfony based CMS.|
|[launchpad](https://github.com/ezsystems/launchpad)|CLI tool to bootstrap an eZ Platform project Docker stack|
|[ezplatform-multi-file-upload](https://github.com/ezsystems/ezplatform-multi-file-upload)|Allows uploading multiple files as new content items at once.|
|[docker-php](https://github.com/ezsystems/docker-php)|Contains php docker image example for use with eZ Platform (and implicit eZ Platform EE and Symfony)|
|[satis](https://github.com/ezsystems/satis)|simple static Composer repository generator|
|[ezplatform-demo-assets](https://github.com/ezsystems/ezplatform-demo-assets)||
|[ezpostgresqlcluster](https://github.com/ezsystems/ezpostgresqlcluster)|eZ Publish PostgreSQL cluster implementation|
|[ezstarrating](https://github.com/ezsystems/ezstarrating)||
|[ezplatform-installer](https://github.com/ezsystems/ezplatform-installer)|This package provides `ezplatform:install` Symfony console command which is the installer for eZ Platform v2.|
|[requirements](https://github.com/ezsystems/requirements)|Requirements repository for eZ Platform development.|
|[ezcs](https://github.com/ezsystems/ezcs)|This repository contains the configuration for various tools to check the eZ coding standards in different languages.|
|[ui-guidelines](https://github.com/ezsystems/ui-guidelines)|This is a resource for designers, product managers, and developers, providing a unified language to build and customize eZ Platform admin user interface (aka Platform UI).|
|[hybrid-platform-ui](https://github.com/ezsystems/hybrid-platform-ui)|Hybrid Platform UI.|
|[hybrid-platform-ui-core-components](https://github.com/ezsystems/hybrid-platform-ui-core-components)|Provides custom elements used in the Hybrid Platform UI.|
|[hybrid-platform-ui-assets](https://github.com/ezsystems/hybrid-platform-ui-assets)|This packages provides the external frontend dependencies needed by the Hybrid Platform UI.|
|[ezflow](https://github.com/ezsystems/ezflow)||
|[ezgmaplocation](https://github.com/ezsystems/ezgmaplocation)||
|[PlatformUIBundle](https://github.com/ezsystems/PlatformUIBundle)|provides the main editing and back-end interface for eZ Platform|
|[PlatformUIAssetsBundle](https://github.com/ezsystems/PlatformUIAssetsBundle)|Repo for containing assets for PlatformUIBundle, branches will only contain meta files and config, tags will contain the assets.|
|[ezplatform-automated-translation](https://github.com/ezsystems/ezplatform-automated-translation)|eZ Automated Translation Bundle|
|[EzSystemsPrivacyCookieBundle](https://github.com/ezsystems/EzSystemsPrivacyCookieBundle)|adds privacy cookie banner|
|[ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext)|Field Type for supporting rich formatted text stored in a structured XML format|
|[CommentsBundle](https://github.com/ezsystems/CommentsBundle)|comment bundle for eZ Platform integrating with Disqus and Facebook and allowing custom integrations|
|[EzSystemsRecommendationBundle](https://github.com/ezsystems/EzSystemsRecommendationBundle)|integration of YooChoose, a content recommendation solution, into eZ Platform|
|[content-on-the-fly-prototype-bundle](https://github.com/ezsystems/content-on-the-fly-prototype-bundle)|Platform UI Content on the Fly feature.|
|[EzSystemsShareButtonsBundle](https://github.com/ezsystems/EzSystemsShareButtonsBundle)|This bundle adds social share buttons into Symfony 2 application (eZ Publish / eZ Platform).|
|[RepositoryProfilerBundle](https://github.com/ezsystems/RepositoryProfilerBundle)|profiles Platform API/SPI and sets up scenarios to be able to continuously test to keep track of performance regressions of repository and underlying storage engines|
|[QueryBuilderBundle](https://github.com/ezsystems/QueryBuilderBundle)|provides a PHP API dedicated to fluently writing repository queries|
|[MarketingAutomationBundle](https://github.com/ezsystems/MarketingAutomationBundle)|This bundle integrates Net-Result’s marketing automation suite into the eZ Publish Platform.|
|[ezstudio-upgrade](https://github.com/ezsystems/ezstudio-upgrade)||
|[alloy-editor](https://github.com/ezsystems/alloy-editor)|Alloy Editor is a modern WYSIWYG editor built on top of CKEditor, designed to create modern web content.|
|[demobundle-data](https://github.com/ezsystems/demobundle-data)|This repository contains binary install data for ezsystems/demobundle.|
|[ezmbpaex](https://github.com/ezsystems/ezmbpaex)|Extension that provides functionality for password expiration and validation.|
|[ezphttprequest](https://github.com/ezsystems/ezphttprequest)|This extension provides ezpHttpRequest, a child class of HttpRequest, provided by the PECL package.|

!!!Enterprise

    |Bundle|Description|
    |---------|-----------|
    |[ezpublish-kernel-ee](https://github.com/ezsystems/ezpublish-kernel-ee)|This is the eZ Platform kernel for enterprise, difference is the stable branches, master is automatically synced.|
    |[ezstudio-notifications](https://github.com/ezsystems/ezstudio-notifications)|Notification system for eZ Platform / eZ Studio.|
    |[ezstudio-cron](https://github.com/ezsystems/ezstudio-cron)|This repository is used by eZ Platform EE 1.x series only. This package exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezpublish:cron:run`|
    |[ez-service-network](https://github.com/ezsystems/ez-service-network)|Service Network is the commercial backend of eZ Publish, providing API's and functionality for things like license handling and authentication needs.|
    |[cloud-deployment-manager](https://github.com/ezsystems/cloud-deployment-manager)|Dedicated cloud deployment manager.|
    |[ezplatform-ee-assets](https://github.com/ezsystems/ezplatform-ee-assets)||
    |[ezpublish-platform](https://github.com/ezsystems/ezpublish-platform)|This is the eZ Publish 5 Platform (ee version of ezpublish-community), it is a meta repository that pulls in all dependencies for full 5.x enterprise build|
    |[StudioUIBundle](https://github.com/ezsystems/StudioUIBundle)|contains the Studio editing interface provided in eZ Platform Enterprise Edition|
    |[ezstudio-form-builder](https://github.com/ezsystems/ezstudio-form-builder)|eZ Studio Form Builder Bundle. Form Builder Bundle is a part of eZ Studio and is installed with eZ Studio meta repository.|
    |[EzLandingPageFieldTypeBundle](https://github.com/ezsystems/EzLandingPageFieldTypeBundle)|Landing Page FieldType|
    |[ezstudio-demo-bundle](https://github.com/ezsystems/ezstudio-demo-bundle)|provides the Landing Page that is at the heart of StudioUI.|
    |[ezstudio-personalized-block](https://github.com/ezsystems/ezstudio-personalized-block)|eZ Systems Personalized Block Bundle|
    |[ezrecommendation](https://github.com/ezsystems/ezrecommendation)|The eZ Recommendation Service provided by YOOCHOOSE represents your first opportunity to customize and personalize your online portal individually for each end user.|
    |[ezma](https://github.com/ezsystems/ezma)|eZ Marketing Automation|
    |[ezmemcachedcluster](https://github.com/ezsystems/ezmemcachedcluster)|This extension adds cluster events support with Memcached backend server.|

### Legacy

|Bundle|Description|
|------|-----------|
|[LegacyBridge](https://github.com/ezsystems/LegacyBridge)|optional bridge between eZ Platform and eZ Publish Legacy that simplifies migration to eZ Platform [Community co-maintained]|
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|XmlText field type for eZ Platform [Community co-maintained]|
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio landing page management|
|[ngsymfonytools-bundle](https://github.com/ezsystems/ngsymfonytools-bundle)|integrates the legacy [netgen/ngsymfonytools](https://github.com/netgen/ngsymfonytools) as a Legacy bundle|
|[ezpublish-legacy-installer](https://github.com/ezsystems/ezpublish-legacy-installer)|A custom Composer installer for eZ Publish legacy extensions|
|[ezpublish-legacy-ee](https://github.com/ezsystems/ezpublish-legacy-ee)|This is the eZ Publish Legacy (4.x) kernel for enterprise. Only stable branches differ, and master is automatically synced from ezsystems/ezpublish-legacy/master.|
|[ezpublish-legacy](https://github.com/ezsystems/ezpublish-legacy)|eZ Publish (aka "legacy kernel" + 3 core "legacy extensions")|
|[ezxmlinstaller](https://github.com/ezsystems/ezxmlinstaller)|The eZ XML Installer extension is a platform to define processes for eZ Publish and execute them.|
|[EditorialInterfaceBundle](https://github.com/ezsystems/EditorialInterfaceBundle)|Prototype of a Editorial interface for eZ Publish 6.x|
|[ezoracle](https://github.com/ezsystems/ezoracle)|This extension adds support for the Oracle database to eZ Publish by plugging into the database framework.|
|[ezlightbox](https://github.com/ezsystems/ezlightbox)|This extension adds support for lightboxes to eZ Publish by adding a new eZ Publish module named "lightbox" (including operations, triggers, fetch functions).|
|[ezfind-ee](https://github.com/ezsystems/ezfind-ee)|eZ Find is a search extension for eZ Publish, providing more functionality and better results than the default search in eZ Publish.|
|[ezcontentstaging](https://github.com/ezsystems/ezcontentstaging)|The goal of the extension is to allow content synchronization between different eZ Publish installations.|
|[ezie](https://github.com/ezsystems/ezie)|An image editor for simple and usual image modifications integrated in the editing interface of any eZ Publish Content Object that has at least an image as attribute.|
|[ezautosave](https://github.com/ezsystems/ezautosave)|Content editing autosave extension for eZ Publish.|
|[ezsurvey](https://github.com/ezsystems/ezsurvey)|Survey module for eZ Publish.|
|[ezscriptmonitor](https://github.com/ezsystems/ezscriptmonitor)|eZ Publish extension that aims to avoid timeout problems and database corruption by moving long running processes from the GUI to the background.|
|[ezfind](https://github.com/ezsystems/ezfind)|eZ Find is a search extension for eZ Publish, providing more functionality and better results than the default search in eZ Publish.|
|[eztags](https://github.com/ezsystems/eztags)|eZ Tags is an eZ Publish extension for taxonomy management and easier classification of content objects, providing more functionality for tagging content objects than ezkeyword datatype included in eZ Publish kernel.|
|[DemoBundle](https://github.com/ezsystems/DemoBundle)|DemoBundle represent a front end web site on eZ Publish 5, for newer examples for eZ Platform see ezplatform-demo.|

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
|[bikeride](https://github.com/ezsystems/bikeride)|Learn eZ Platform with our Beginner Tutorial|
|[ez-beginner-tutorial](https://github.com/ezsystems/ez-beginner-tutorial)|Files related to the eZ Platform Beginner Tutorial|
|[ezplatform-ee-beginner-tutorial](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial)|This repository contains resources used in the eZ Platform Enterprise Edition Beginner Tutorial.|
|[ExtendingPlatformUIConferenceBundle](https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle)|This repository contains the bundle that is created in the Extending PlatformUI tutorial.|

### Documentation

|Bundle|Description|
|------|-----------|
|[developer-documentation](https://github.com/ezsystems/developer-documentation)|Source for the developer documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP. https://doc.ezplatform.com|
|[user-documentation](https://github.com/ezsystems/user-documentation)|Source for the user documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP.|
|[ezservices-documentation](https://github.com/ezsystems/ezservices-documentation)|Source for the eZ Services documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP.|

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