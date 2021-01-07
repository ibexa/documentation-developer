# Bundles

A bundle in Symfony (and [[= product_name =]]) is a separate part of your application that implements a feature.
You can create bundles yourself or make use of available open-source bundles.
You can also reuse the bundles you create in other projects or share them with the community.

Many [[= product_name =]] functionalities are provided through separate bundles included in the installation.
You can see the bundles that are automatically installed with [[= product_name =]]
in the respective `composer.json` files, for example for [Ibexa Content](https://github.com/ibexa/content/blob/master/composer.json).

## Working with bundles

All bundles containing built-in [[= product_name =]] functionalities are installed automatically.
Additionally, you can install community-developed bundles from [[[= product_name =]] Packages.](https://developers.ibexa.co/packages)

To learn how to create your own bundles, see [Symfony documentation on bundles.](https://symfony.com/doc/5.0/bundles.html)

### Overriding third-party bundles

When you use an external bundle, you can override its parts, such as templates, controllers, etc.
To do so, make use of [Symfony's bundle override mechanism](https://symfony.com/doc/5.0/bundles/override.html).
Note that when overriding files, the path inside your application has to correspond to the path inside the bundle.

### Removing bundles

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need),
see the [How to Remove a Bundle](http://symfony.com/doc/5.0/bundles/remove.html) instruction in Symfony doc.

## Core packages

|Bundle|Description|
|---------|-----------|
|[ezsystems/ez-support-tools](https://github.com/ezsystems/ez-support-tools)|System information|
|[ezsystems/ezplatform-admin-ui-assets](https://github.com/ezsystems/ezplatform-admin-ui-assets)|Assets for the Back Office|
|[ezsystems/ezplatform-admin-ui](https://github.com/ezsystems/ezplatform-admin-ui)|Back Office interface|
|[ezsystems/ezplatform-content-forms](https://github.com/ezsystems/ezplatform-content-forms)|Form-based integration for the Symfony Forms into Content and User objects in kernel|
|[ezsystems/ezplatform-core](https://github.com/ezsystems/ezplatform-core)|Core system functionalities|
|[ezsystems/ezplatform-cron](https://github.com/ezsystems/ezplatform-cron)|Cron package for use via a the `ezplatform:cron:run` command|
|[ezsystems/ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|[Design fallback system](design_engine.md)|
|[ezsystems/ezplatform-graphql](https://github.com/ezsystems/ezplatform-graphql)|GraphQL server for [[= product_name =]]|
|[ezsystems/ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache)|[HTTP cache handling](http_cache.md), using multi tagging|
|[ezsystems/ezplatform-kernel](https://github.com/ezsystems/ezplatform-kernel)|Core of the [[= product_name =]] application|
|[ezsystems/ezplatform-matrix-fieldtype](https://github.com/ezsystems/ezplatform-matrix-fieldtype)|[Matrix Field Type](../api/field_type_reference.md#matrix-field-type)|
|[ezsystems/ezplatform-query-fieldtype](https://github.com/ezsystems/ezplatform-query-fieldtype)|[Query Field Type](../api/field_type_reference.md#query-field-type)|
|[ezsystems/ezplatform-rest](https://github.com/ezsystems/ezplatform-rest)|REST API|
|[ezsystems/ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext)|Field Type for supporting rich-formatted text stored in a structured XML format|
|[ezsystems/ezplatform-search](https://github.com/ezsystems/ezplatform-search)|Common search functionalities|
|[ezsystems/ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|[Solr-powered](http://lucene.apache.org/solr/) search handler|
|[ezsystems/ezplatform-standard-design](https://github.com/ezsystems/ezplatform-standard-design)|Standard design and theme to be handled by `ezplatform-design-engine`|
|[ezsystems/ezplatform-user](https://github.com/ezsystems/ezplatform-user)|User management|

## Ibexa Content packages

|Bundle|Description|
|---------|-----------|
|ezsystems/date-based-publisher|Date-based publishing functionality|
|ezsystems/ezcommerce-base-design|Standard design and theme for the shop|
|ezsystems/ezcommerce-checkout|Shop checkout functionality|
|ezsystems/ezcommerce-fieldtypes|Shop-specific Field Types|
|ezsystems/ezcommerce-price-engine|Engine for handling prices|
|ezsystems/ezcommerce-shop-ui|UI for the shop front page|
|ezsystems/ezcommerce-shop|Main shop functionalities|
|ezsystems/ezplatform-calendar|Calendar tab with a calendar widget|
|ezsystems/ezplatform-connector-dam|Connector for DAM (Digital Asset Management) systems|
|ezsystems/ezplatform-elastic-search-engine|Integration with Elasticsearch search engine|
|ezsystems/ezplatform-http-cache-fastly|Fastly support for `ezplatform-http-cache`, for use on Platform.sh or standalone|
|ezsystems/ezplatform-icons|Icon set for the Back Office|
|ezsystems/ezplatform-personalization|Functionality for personalized recommendations|
|ezsystems/ezplatform-version-comparison|Enables comparing between two versions of the same Field|
|ezsystems/ezplatform-workflow|Collaboration feature that enables you to send content draft to any user for a review or rewriting|
|ezsystems/ezrecommendation-client|Client for connecting with the personalization engine|
|ibexa/migrations|[Migration of Repository data](data_migration.md)|
|ibexa/oauth2-client|Integration with [`knpuniversity/oauth2-client-bundle`](https://github.com/knpuniversity/oauth2-client-bundle)|

## Ibexa Experience packages

|Bundle|Description|
|---------|-----------|
|ezsystems/ezplatform-ee-installer|Provides the `ezplatform:install` command which is the installer for Ibexa Experience|
|ezsystems/ezplatform-form-builder|Enables creating Form Content items with multiple form fields|
|ezsystems/ezplatform-page-builder|Page editor|
|ezsystems/ezplatform-page-fieldtype|Page handling Field Type|
|ezsystems/ezplatform-permissions|Additional permission functionalities|
|ezsystems/ezplatform-segmentation|Segment functionality for profiling the content displayed to specific users|
|ezsystems/ezplatform-site-factory|Enables configuration of sites from UI|
|ibexa/image-editor|[Image Editor](image_editor.md)|

## Ibexa Commerce packages

|Bundle|Description|
|---------|-----------|
|ezsystems/ezcommerce-admin-ui|Shop-related Back Office functionalities|
|ezsystems/ezcommerce-erp-admin|ERP connection for the shop|
|ezsystems/ezcommerce-order-history|[Order history](order_history/orderhistory.md) functionality|
|ezsystems/ezcommerce-page-builder|Shop-related Page blocks|
|ezsystems/ezcommerce-transaction|Transactional shop functionalities|
