# eZ Structure

The eZ Platform root directory contains multiple sub-directories.
Each sub-directory is dedicated to a specific part of the system and contains a collection of logically related files.
The following table gives an overview of the main eZ Platform directories.


## Basic directories - READ ONLY

|Directory|Description|
|---------|-----------|
|[ezpublish-api](https://github.com/ezsystems/ezpublish-api)|Subtree split of the eZ Publish 5 (ezsystems/ezpublish-kernel) API interfaces and domain objects.|
|[ezpublish-spi](https://github.com/ezsystems/ezpublish-spi)|Subtree split of the eZ Publish 5 (ezsystems/ezpublish-kernel) SPI (persistence) interfaces.|
|[ezwt-ls-extension](https://github.com/ezsystems/ezwt-ls-extension)|Subtree split from ezsystems/ezwt, for use via Composer|
|[ezwebin-ls-extension](https://github.com/ezsystems/ezwebin-ls-extension)|Subtree split from ezsystems/ezwebin, for use via Composer.|
|[ezstarrating-ls-extension](https://github.com/ezsystems/ezstarrating-ls-extension)|Subtree split from ezsystems/ezstarrating, for use via Composer.|
|[ezgmaplocation-ls-extension](https://github.com/ezsystems/ezgmaplocation-ls-extension)|Subtree split from ezsystems/ezgmaplocation, for use via Composer|
|[ezdemo-ls-extension](https://github.com/ezsystems/ezdemo-ls-extension)|Subtree split from ezsystems/ezdemo, for use via Composer.|
|[ezflow-ls-extension](https://github.com/ezsystems/ezflow-ls-extension)|Subtree split from ezsystems/ezflow, for use via Composer.|
|[ezcomments-ls-extension](https://github.com/ezsystems/ezcomments-ls-extension)|Subtree split of legacy ezcomments extension from https://github.com/ezsystems/ezwt. For use via Composer.|

## Directory structure - required bundles ezplatform

|Directory|Description|
|---------|-----------|
|[ezplatform](https://github.com/ezsystems/ezplatform)|Meta repository that pulls in all dependencies for clean distribution of eZ Platform.|
|[ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel)|Directory that contains all the kernel files such as the core kernel classes, modules, views, datatypes, etc. This is where the core of the system resides. Only experts should tamper with this part.|
|[repository-forms](https://github.com/ezsystems/repository-forms)|Repository forms.|
|[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|Solr powered search handler for eZ Platform (and branch 1.0 for eZ Publish 5.4)|
|[ez-support-tools](https://github.com/ezsystems/ez-support-tools)|eZ Support Tools Bundle, provides functionality for system information and in the future tools for identifying issues.|
|[ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache)|HTTP cache handling for eZ Platform, using multi tagging (incl Varnish xkey).|
|[ezplatform-admin-ui](https://github.com/ezsystems/ezplatform-admin-ui)|Repository dedicated to the eZ Platform Admin UI Bundle, Admin UI for eZ Platform v2+.|
|[ezplatform-admin-ui-modules](https://github.com/ezsystems/ezplatform-admin-ui-modules)|Repository dedicated to re-useable React JS components for eZ Platform Admin UI|
|[ezplatform-admin-ui-assets](https://github.com/ezsystems/ezplatform-admin-ui-assets)|eZ Platform Admin UI Assets Bundle|
|[ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|Design fallback system for eZ Platform similar to legacy design fallback system. Lets you define fallback order for templates and assets.|
|[ezplatform-standard-design](https://github.com/ezsystems/ezplatform-standard-design)|eZ Platform Standard Design Bundle. This Bundle defines standard Design and Theme to be handled by ezplatform-design-engine.|
|[ezplatform-cron](https://github.com/ezsystems/ezplatform-cron)|This package exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezplatform:cron:run`|
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|Bundle for common reusable sentance implementations and other common needs for Behat testing in eZ bundles/projects.|


## Directory structure - required bundles ezplatform-ee

|Directory|Description|
|---------|-----------|
|[ezplatform-ee](https://github.com/ezsystems/ezplatform-ee)|Fork of the "ezplatform" meta repository, contains changes to composer.json that pull in all dependencies from updates.ez.no for eZ Platform Enterprise Edition (a commercial distribution of eZ Platform with additional features).|
|[date-based-publisher](https://github.com/ezsystems/date-based-publisher)|This repository contains a Bundle that provides the date based publishing functionality for the eZ Studio product.|
|[flex-workflow](https://github.com/ezsystems/flex-workflow)|Flex Workflow Implementation|
|[ezplatform-page-fieldtype](https://github.com/ezsystems/ezplatform-page-fieldtype)|Page handling FieldType for eZ Platform EE 2.2+|
|[ezplatform-page-builder](https://github.com/ezsystems/ezplatform-page-builder)|Repository dedicated to the eZ Platform Page Builder Bundle|
|[ezplatform-ee-installer](https://github.com/ezsystems/ezplatform-ee-installer)|This package provides `ezplatform:install` Symfony console command which is the installer for eZ Platform Enterprise v2.|
|[ezplatform-http-cache-fastly](https://github.com/ezsystems/ezplatform-http-cache-fastly)|eZ Platform Enterprise Bundle extending ezplatform-http-cache to support Fastly, for use on Platform.sh PE or standalone|



## Additiona bundles

|Directory|Description|
|---------|-----------|
|[ezplatform-demo](https://github.com/ezsystems/ezplatform-demo)|Fork of `ezplatform` meta repository that contains code and dependencies for demo distribution of eZ Platform. Not recommended for a clean install for new projects, but great for observation and learning!|
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|(Community co-maintained) The XmlText Field Type isn't officially supported by eZ Platform.|
|[ezwt](https://github.com/ezsystems/ezwt)||
|[eztags](https://github.com/ezsystems/eztags)|eZ Tags is an eZ Publish extension for taxonomy management and easier classification of content objects, providing more functionality for tagging content objects than ezkeyword datatype included in eZ Publish kernel.|
|[ezpublish-legacy](https://github.com/ezsystems/ezpublish-legacy)|eZ Publish (aka "legacy kernel" + 3 core "legacy extensions")|
|[ez-js-rest-client](https://github.com/ezsystems/ez-js-rest-client)|Javascript REST client for eZ Platform RESTv2 API, mimics PHP API found in eZ Platform.|
|[ezplatform-i18n](https://github.com/ezsystems/ezplatform-i18n)|Centralized internationalization of eZ Platform, the open-source Symfony based CMS.|
|[LegacyBridge](https://github.com/ezsystems/LegacyBridge)|(Community co-maintained) Formerly LegacyBundle, this was moved out and can be used as a optional bridge between eZ Platform and eZ Publish Legacy to simplify migration to eZ Platform|
|[ezplatform-com](https://github.com/ezsystems/ezplatform-com)|eZPlatform.com - The eZ Systems Developer Hub for the Open Source PHP CMS eZ Platform|
|[launchpad](https://github.com/ezsystems/launchpad)|CLI tool to bootstrap an eZ Platform project Docker stack|
|[ezplatform-multi-file-upload](https://github.com/ezsystems/ezplatform-multi-file-upload)|Allows uploading multiple files as new content items at once.|
|[docker-php](https://github.com/ezsystems/docker-php)|Contains php docker image example for use with eZ Platform (and implicit eZ Platform EE and Symfony)|
|[ezfind](https://github.com/ezsystems/ezfind)|eZ Find is a search extension for eZ Publish, providing more functionality and better results than the default search in eZ Publish.|
|[ezscriptmonitor](https://github.com/ezsystems/ezscriptmonitor)|eZ Publish extension that aims to avoid timeout problems and database corruption by moving long running processes from the GUI to the background.|
|[satis](https://github.com/ezsystems/satis)|Simple static Composer repository generator.|
|[ezplatform-ui-2.0-introduction](https://github.com/ezsystems/ezplatform-ui-2.0-introduction)|Repo for introduction of v2 UI, `v2_extending_admin` for up-to-date v2.x steps.|
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
|[ezpublish-legacy-installer](https://github.com/ezsystems/ezpublish-legacy-installer)|A custom Composer installer for eZ Publish legacy extensions|
|[ezflow](https://github.com/ezsystems/ezflow)||
|[ezgmaplocation](https://github.com/ezsystems/ezgmaplocation)||
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|A set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio Landing Page management.|
|[ezxmlinstaller](https://github.com/ezsystems/ezxmlinstaller)|The eZ XML Installer extension is a platform to define processes for eZ Publish and execute them.|


Enterprise:

|Directory|Description|
|---------|-----------|
|[ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)|Fork of the "ezplatform-ee" meta repository, contains changes to composer.json, AppKernel.php and config necessary to enable eZ Platform Enterprise Edition Demo.|
|[ezpublish-legacy-ee](https://github.com/ezsystems/ezpublish-legacy-ee)|This is the eZ Publish Legacy (4.x) kernel for enterprise. Only stable branches differ, and master is automatically synced from ezsystems/ezpublish-legacy/master.|
|[ezpublish-kernel-ee](https://github.com/ezsystems/ezpublish-kernel-ee)|This is the eZ Platform kernel for enterprise, difference is the stable branches, master is automatically synced.|
|[ezstudio-notifications](https://github.com/ezsystems/ezstudio-notifications)|Notification system for eZ Platform / eZ Studio.|
|[ezstudio-cron](https://github.com/ezsystems/ezstudio-cron)|This repository is used by eZ Platform EE 1.x series only. This package exposes cron/cron package for use in eZ Platform (or just plain Symfony) via a simple command `ezpublish:cron:run`|
|[ez-service-network](https://github.com/ezsystems/ez-service-network)|Service Network is the commercial backend of eZ Publish, providing API's and functionality for things like license handling and authentication needs.|
|[cloud-deployment-manager](https://github.com/ezsystems/cloud-deployment-manager)|Dedicated cloud deployment manager.|
|[ezfind-ee](https://github.com/ezsystems/ezfind-ee)|eZ Find is a search extension for eZ Publish, providing more functionality and better results than the default search in eZ Publish.|
|[ezplatform-ee-assets](https://github.com/ezsystems/ezplatform-ee-assets)||
|[ezpublish-platform](https://github.com/ezsystems/ezpublish-platform)|This is the eZ Publish 5 Platform (ee version of ezpublish-community), it is a meta repository that pulls in all dependencies for full 5.x enterprise build|



## Documentation

|Bundle|Description|
|------|-----------|
|[developer-documentation](https://github.com/ezsystems/developer-documentation)|Source for the developer documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP. https://doc.ezplatform.com|
|[user-documentation](https://github.com/ezsystems/user-documentation)|Source for the user documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP.|
|[ezservices-documentation](https://github.com/ezsystems/ezservices-documentation)|Source for the eZ Services documentation for eZ Platform, an open source CMS based on the Symfony Full Stack Framework in PHP.|
|[platformsh-docs](https://github.com/ezsystems/platformsh-docs)|Platform.sh documentation https://docs.platform.sh/|
|[apidoc.ez.no](https://github.com/ezsystems/apidoc.ez.no)|Apidocs.ez.no documentation builder for eZP|
|[ezodf](https://github.com/ezsystems/ezodf)|This extension enables import and export of OpenOffice.org Writer documents within eZ Publish.|
|[ezsystems.github.com](https://github.com/ezsystems/ezsystems.github.com)|
Contains UI/Style guideline and generated API documentation for eZ Platform frontend components.|
|[bikeride](https://github.com/ezsystems/bikeride)|Learn eZ Platform with our Beginner Tutorial|
|[ez-beginner-tutorial](https://github.com/ezsystems/ez-beginner-tutorial)|Files related to the eZ Platform Beginner Tutorial|
|[ezplatform-ee-beginner-tutorial](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial)|This repository contains resources used in the eZ Platform Enterprise Edition Beginner Tutorial.|
|[ExtendingPlatformUIConferenceBundle](https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle)|This repository contains the bundle that is created in the Extending PlatformUI tutorial.|

## Bundle structure

|Bundle|Description|
|------|-----------|
|[PlatformUIBundle](https://github.com/ezsystems/PlatformUIBundle)|Main Bundle to provide YUI based editorial/admin UI for eZ Platform v1 on top of REST API (In v2 replaced by ezplatform-admin-ui, a pure Symfony based Admin UI)|
|[PlatformUIAssetsBundle](https://github.com/ezsystems/PlatformUIAssetsBundle)|Repo for containing assets for PlatformUIBundle, branches will only contain meta files and config, tags will contain the assets.|
|[ezplatform-drawio-fieldtype](https://github.com/ezsystems/ezplatform-drawio-fieldtype)|Bundle providing support for diagrams editing in eZ Platform via draw.io.|
|[CookbookBundle](https://github.com/ezsystems/CookbookBundle)|eZ Publish 5.x / eZ Platform Cookbook examples|
|[ezplatform-automated-translation](https://github.com/ezsystems/ezplatform-automated-translation)|eZ Automated Translation Bundle|

|[EzSystemsPrivacyCookieBundle](https://github.com/ezsystems/EzSystemsPrivacyCookieBundle)|This bundle adds privacy cookie banner into Symfony 2 application.|
|[TweetFieldTypeBundle](https://github.com/ezsystems/TweetFieldTypeBundle)|Tweet FieldType for the eZ Platform FieldType tutorial|
|[ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext)|eZ Platform Rich Text Field Type Bundle. This Bundle provides RichText (ezrichtext) Field Type for eZ Platform 2.1 and higher. It is a Field Type for supporting rich formatted text stored in a structured XML format.|
|[CommentsBundle](https://github.com/ezsystems/CommentsBundle)|Comment bundle for eZ Platform integrating with Disqus and Facebook and allowing custom integrations.|
|[EzSystemsRecommendationBundle](https://github.com/ezsystems/EzSystemsRecommendationBundle)|Integration of YooChoose, a content recommendation solution, into eZ Platform.|
|[content-on-the-fly-prototype-bundle](https://github.com/ezsystems/content-on-the-fly-prototype-bundle)|Platform UI Content on the Fly feature.|
|[EzSystemsShareButtonsBundle](https://github.com/ezsystems/EzSystemsShareButtonsBundle)|This bundle adds social share buttons into Symfony 2 application (eZ Publish / eZ Platform).|
|[RepositoryProfilerBundle](https://github.com/ezsystems/RepositoryProfilerBundle)|Bundle to profile eZ Platform API/SPI and setup scenarios to be able to continuously test to keep track of performance regressions of repository and underlying storage engines(s)|
|[ezplatform-link-manager](https://github.com/ezsystems/ezplatform-link-manager)|This package provides prototype of Public API and UI for links management in eZ Platform. NOTE: This bundle is currently only integrating with eZ Platform UI 1.x, integration with 2.x is planned.|
|[QueryBuilderBundle](https://github.com/ezsystems/QueryBuilderBundle)|This bundle for eZ Publish, the open-source CMS platform, provides a PHP API dedicated to fluently writing repository queries.|
|[DemoBundle](https://github.com/ezsystems/DemoBundle)|DemoBundle represent a front end web site on eZ Publish 5, for newer examples for eZ Platform see ezplatform-demo.|
|[MarketingAutomationBundle](https://github.com/ezsystems/MarketingAutomationBundle)|This bundle integrates Net-Result’s marketing automation suite into the eZ Publish Platform.|
|[ezstudio-upgrade](https://github.com/ezsystems/ezstudio-upgrade)||
|[EditorialInterfaceBundle](https://github.com/ezsystems/EditorialInterfaceBundle)|Prototype of a Editorial interface for eZ Publish 6.x|
|[alloy-editor](https://github.com/ezsystems/alloy-editor)|Alloy Editor is a modern WYSIWYG editor built on top of CKEditor, designed to create modern web content.|
|[ezoracle](https://github.com/ezsystems/ezoracle)|This extension adds support for the Oracle database to eZ Publish by plugging into the database framework.|
|[demobundle-data](https://github.com/ezsystems/demobundle-data)|This repository contains binary install data for ezsystems/demobundle.|
|[ezie](https://github.com/ezsystems/ezie)|An image editor for simple and usual image modifications integrated in the editing interface of any eZ Publish Content Object that has at least an image as attribute.|
|[ezautosave](https://github.com/ezsystems/ezautosave)|Content editing autosave extension for eZ Publish.|
|[ezsurvey](https://github.com/ezsystems/ezsurvey)|Survey module for eZ Publish.|
|[ezmbpaex](https://github.com/ezsystems/ezmbpaex)|Extension that provides functionality for password expiration and validation.|
|[ngsymfonytools-bundle](https://github.com/ezsystems/ngsymfonytools-bundle)|ngsymfonytools-bundle integrates the legacy netgen/ngsymfonytools as a Legacy bundle, a feature introduced in eZ Publish 5.3.|
|[ezphttprequest](https://github.com/ezsystems/ezphttprequest)|This extension provides ezpHttpRequest, a child class of HttpRequest, provided by the PECL package.|
|[ezlightbox](https://github.com/ezsystems/ezlightbox)|This extension adds support for lightboxes to eZ Publish by adding a new eZ Publish module named "lightbox" (including operations, triggers, fetch functions).|



Enterprise:

|Bundle|Description|
|------|-----------|
|[StudioUIBundle](https://github.com/ezsystems/StudioUIBundle)|eZ Studio is the "content studio" built on top of the platform. StudioUIBundle provides web interface for eZ Studio features.|
|[ezstudio-form-builder](https://github.com/ezsystems/ezstudio-form-builder)|eZ Studio Form Builder Bundle. Form Builder Bundle is a part of eZ Studio and is installed with eZ Studio meta repository.|
|[EzLandingPageFieldTypeBundle](https://github.com/ezsystems/EzLandingPageFieldTypeBundle)|Landing Page FieldType|
|[ezstudio-demo-bundle](https://github.com/ezsystems/ezstudio-demo-bundle)|StudioDemoBundle represent a demo front-end website with eZ Studio.|
|[ezstudio-personalized-block](https://github.com/ezsystems/ezstudio-personalized-block)|eZ Systems Personalized Block Bundle|
|[ezrecommendation](https://github.com/ezsystems/ezrecommendation)|The eZ Recommendation Service provided by YOOCHOOSE represents your first opportunity to customize and personalize your online portal individually for each end user.|
|[ezcontentstaging](https://github.com/ezsystems/ezcontentstaging)|The goal of the extension is to allow content synchronization between different eZ Publish installations.|
|[ezma](https://github.com/ezsystems/ezma)|eZ Marketing Automation|
|[ezmemcachedcluster](https://github.com/ezsystems/ezmemcachedcluster)|This extension adds cluster events support with Memcached backend server.|
