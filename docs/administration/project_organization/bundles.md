---
description: Ibexa DXP is composed of bundles containing different parts of the application.
---

# Bundles

A bundle in Symfony (and [[= product_name =]]) is a separate part of your application that implements a feature.
You can create bundles yourself or make use of available open-source bundles.
You can also reuse the bundles you create in other projects or share them with the community.

Many [[= product_name =]] functionalities are provided through separate bundles included in the installation.
You can see the bundles that are automatically installed with [[= product_name =]]
in the respective `composer.json` files.
For example, for Ibexa Content, see the [JSON file on GitHub](https://github.com/ibexa/content/blob/master/composer.json).

## Working with bundles

All bundles containing built-in [[= product_name =]] functionalities are installed automatically.
Additionally, you can install community-developed bundles from [[[= product_name =]] Packages.](https://developers.ibexa.co/packages)

To learn how to create your own bundles, see [Symfony documentation on bundles.]([[= symfony_doc =]]/bundles.html)

### Overriding third-party bundles

When you use an external bundle, you can override its parts, such as templates, controllers, etc.
To do so, make use of [Symfony's bundle override mechanism]([[= symfony_doc =]]/bundles/override.html).
Note that when overriding files, the path inside your application has to correspond to the path inside the bundle.

### Removing bundles

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need),
see the [How to Remove a Bundle]([[= symfony_doc =]]/bundles/remove.html) instruction in Symfony doc.

## Core packages

!!! tip

    Ibexa Open Source is composed of the core packages.

|Bundle|Description|
|---------|-----------|
|[ibexa/support-tools](https://github.com/ibexa/support-tools)|System information|
|[ibexa/admin-ui-assets](https://github.com/ibexa/admin-ui-assets)|Assets for the Back Office|
|[ibexa/admin-ui](https://github.com/ibexa/admin-ui)|Back Office interface|
|[ibexa/content-forms](https://github.com/ibexa/content-forms)|Form-based integration for the Symfony Forms into Content and User objects in kernel|
|[ibexa/core-extensions](https://github.com/ibexa/core-extensions)|Core system functionalities|
|[ibexa/cron](https://github.com/ibexa/cron)|Cron package for use with the `ibexa:cron:run` command|
|[ibexa/design-engine](https://github.com/ibexa/design-engine)|[Design fallback system](design_engine.md)|
|[ibexa/graphql](https://github.com/ibexa/graphql)|GraphQL server for [[= product_name =]]|
|[ibexa/http-cache](https://github.com/ibexa/http-cache)|[HTTP cache handling](http_cache.md), using multi tagging|
|[ibexa/core](https://github.com/ibexa/core)|Core of the [[= product_name =]] application|
|[ibexa/matrix-fieldtype](https://github.com/ibexa/matrix-fieldtype)|[Matrix Field Type](matrixfield.md)|
|[ibexa/query-fieldtype](https://github.com/ibexa/query-fieldtype)|[Query Field Type](contentqueryfield.md)|
|[ibexa/rest](https://github.com/ibexa/rest)|REST API|
|[ibexa/richtext](https://github.com/ibexa/richtext)|Field Type for supporting rich-formatted text stored in a structured XML format|
|[ibexa/search](https://github.com/ibexa/search)|Common search functionalities|
|[ibexa/solr-search-engine](https://github.com/ibexa/solr-search-engine)|[Solr-powered](http://lucene.apache.org/solr/) search handler|
|[ibexa/standard-design](https://github.com/ibexa/standard-design)|Standard design and theme to be handled by `design-engine`|
|[ibexa/user](https://github.com/ibexa/user)|User management|

## Ibexa Content packages

|Bundle|Description|
|---------|-----------|
|ibexa/date-based-publisher|Date-based publishing functionality|
|ibexa/commerce-base-design|Standard design and theme for the shop|
|ibexa/commerce-checkout|Shop checkout functionality|
|ibexa/commerce-fieldtypes|Shop-specific Field Types|
|ibexa/commerce-price-engine|Engine for handling prices|
|ibexa/commerce-shop-ui|UI for the shop front page|
|ibexa/commerce-shop|Main shop functionalities|
|ibexa/calendar|Calendar tab with a calendar widget|
|ibexa/connector-dam|Connector for DAM (Digital Asset Management) systems|
|ibexa/elastic-search-engine|Integration with Elasticsearch search engine|
|ibexa/http-cache-fastly|Fastly support for `http-cache`, for use on Platform.sh or standalone|
|ibexa/icons|Icon set for the Back Office|
|ibexa/personalization|Functionality for personalized recommendations|
|ibexa/version-comparison|Enables comparing between two versions of the same Field|
|ibexa/workflow|Collaboration feature that enables you to send content draft to any user for a review or rewriting|
|ibexa/recommendation-client|Client for connecting with the personalization engine|
|ibexa/image-editor|[Image Editor](configure_image_editor.md)|
|ibexa/installer|Provides the `ibexa:install` command|
|ibexa/migrations|[Migration of Repository data](data_migration.md)|
|ibexa/oauth2-client|Integration with [`knpuniversity/oauth2-client-bundle`](https://github.com/knpuniversity/oauth2-client-bundle)|

## Ibexa Experience packages

|Bundle|Description|
|---------|-----------|
|ibexa/form-builder|Enables creating Form Content items with multiple form fields|
|ibexa/page-builder|Page editor|
|ibexa/page-fieldtype|Page handling Field Type|
|ibexa/permissions|Additional permission functionalities|
|ibexa/segmentation|Segment functionality for profiling the content displayed to specific users|
|ibexa/site-factory|Enables configuration of sites from UI|

## Ibexa Commerce packages

|Bundle|Description|
|---------|-----------|
|ibexa/commerce-admin-ui|Shop-related Back Office functionalities|
|ibexa/commerce-erp-admin|ERP connection for the shop|
|ibexa/commerce-order-history|[Order history](order_history.md) functionality|
|ibexa/commerce-page-builder|Shop-related Page blocks|
|ibexa/commerce-transaction|Transactional shop functionalities|
