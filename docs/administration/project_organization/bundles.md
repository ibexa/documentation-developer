---
description: Ibexa DXP is composed of bundles containing different parts of the application.
page_type: reference
---

# Bundles

A bundle in Symfony (and [[= product_name =]]) is a separate part of your application that implements a feature.
You can [create bundles yourself](package_structure.md) or make use of available open-source bundles.
You can also reuse the bundles you create in other projects or share them with the community.

Many [[= product_name =]] functionalities are provided through separate bundles included in the installation.
You can see the bundles that are automatically installed with [[= product_name =]] in the respective `composer.json` files.
For example, for [[= product_name_headless =]], see the [JSON file on GitHub](https://github.com/ibexa/headless/blob/master/composer.json).

!!! caution "Deprecated legacy Commerce bundles"

    As of [[= product_name =]] v4.4 all `ibexa/commerce` packages are deprecated.
    They're gradually replaced by their revamped counterparts and removed completely from the product in version v5.0.

## Working with bundles

All bundles containing built-in [[= product_name =]] functionalities are installed automatically.
Additionally, you can install community-developed bundles from [[[= product_name =]] Packages.](https://developers.ibexa.co/packages)

To learn how to create your own bundles, see [Symfony documentation on bundles]([[= symfony_doc =]]/bundles.html).

### Overriding third-party bundles

When you use an external bundle, you can override its parts, such as templates or controllers.
To do so, make use of [Symfony's bundle override mechanism]([[= symfony_doc =]]/bundles/override.html).
When overriding files, the path inside your application has to correspond to the path inside the bundle.

### Removing bundles

To remove a bundle (either one you created yourself, or an out-of-the-box one that you don't need), see the [How to Remove a Bundle]([[= symfony_doc =]]/bundles/remove.html) instruction in Symfony doc.

## Core packages

!!! tip

    Ibexa Open Source is composed of the core packages.

|Bundle|Description|
|---------|-----------|
|[ibexa/admin-ui](https://github.com/ibexa/admin-ui)|Back office interface|
|[ibexa/admin-ui-assets](https://github.com/ibexa/admin-ui-assets)|Assets for the back office|
|[ibexa/content-forms](https://github.com/ibexa/content-forms)|Form-based integration for the Symfony Forms into content and user objects in kernel|
|[ibexa/core](https://github.com/ibexa/core)|Core of the [[= product_name =]] application|
|[ibexa/core-persistence](https://github.com/ibexa/core-persistence)|Core system persistence|
|[ibexa/cron](https://github.com/ibexa/cron)|Cron package for use with the `ibexa:cron:run` command|
|[ibexa/design-engine](https://github.com/ibexa/design-engine)|[Design fallback system](design_engine.md)|
|[ibexa/doctrine-schema](https://github.com/ibexa/doctrine-schema)| Basic abstraction layer for cross-DBMS schema import|
|[ibexa/fieldtype-matrix](https://github.com/ibexa/fieldtype-matrix)|[Matrix field type](matrixfield.md)|
|[ibexa/fieldtype-query](https://github.com/ibexa/fieldtype-query)|[Query field type](contentqueryfield.md)|
|[ibexa/fieldtype-richtext](https://github.com/ibexa/fieldtype-richtext)|field type for supporting rich-formatted text stored in a structured XML format|
|[ibexa/graphql](https://github.com/ibexa/graphql)|GraphQL server for [[= product_name =]]|
|[ibexa/http-cache](https://github.com/ibexa/http-cache)|[HTTP cache handling](http_cache.md), using multi tagging|
|[ibexa/i18n](https://github.com/ibexa/i18n)|Centralized translations to ease synchronization with Crowdin|
|[ibexa/post-install](https://github.com/ibexa/post-install)|Post installation tool|
|[ibexa/rest](https://github.com/ibexa/rest)|REST API|
|[ibexa/search](https://github.com/ibexa/search)|Common search functionalities|
|[ibexa/solr](https://github.com/ibexa/solr)|[Solr-powered](https://solr.apache.org/) search handler|
|[ibexa/standard-design](https://github.com/ibexa/standard-design)|Standard design and theme to be handled by `design-engine`|
|[ibexa/system-info](https://github.com/ibexa/system-info)| Information about the system [[= product_name =]] is running on|
|[ibexa/user](https://github.com/ibexa/user)|User management|

## [[= product_name_headless =]] packages

|Bundle|Description|
|---------|-----------|
|ibexa/oss|Core packages|
|ibexa/content-tree|content tree functionality|
|ibexa/connect|[[[= product_name_connect =]]]([[= connect_doc =]]/)|
|ibexa/calendar|Calendar tab with a calendar widget|
|ibexa/connector-dam|Connector for DAM (Digital Asset Management) systems|
|ibexa/elasticsearch|Integration with Elasticsearch search engine|
|ibexa/fastly|Fastly support for `http-cache`, for use on Platform.sh or standalone|
|ibexa/icons|Icon set for the back office|
|ibexa/image-editor|[Image Editor](configure_image_editor.md)|
|ibexa/installer|Provides the `ibexa:install` command|
|ibexa/measurement|Measurement field type and measurement product catalog attribute|
|ibexa/migrations|[Migration of repository data](data_migration.md)|
|[ibexa/oauth2-client](oauth_client.md)|Authenticate user through a third-party OAuth 2 server, integration with [`knpuniversity/oauth2-client-bundle`](https://github.com/knpuniversity/oauth2-client-bundle)|
|[ibexa/oauth2-server](oauth_server.md)|Allow resource access to OAuth 2 client|
|ibexa/personalization|Functionality for personalized recommendations|
|ibexa/product-catalog|Product catalog functionality|
|ibexa/scheduler|Date-based publishing functionality|
|ibexa/seo|Search Engine Optimization (SEO) tool|
|ibexa/taxonomy|Taxonomy functionality|
|ibexa/tree-builder|Tree builder functionality|
|ibexa/version-comparison|Enables comparing between two versions of the same field|
|ibexa/workflow|Collaboration feature that enables you to send content draft to any user for a review or rewriting|
|ibexa/recommendation-client|Client for connecting with the personalization engine **deprecated**|
|ibexa/commerce-base-design|Standard design and theme for the shop **deprecated** |
|ibexa/commerce-checkout|Shop checkout functionality **deprecated** |
|ibexa/commerce-fieldtypes|Shop-specific field types **deprecated** |
|ibexa/commerce-price-engine|Engine for handling prices **deprecated** |
|ibexa/commerce-shop-ui|UI for the shop front page **deprecated** |
|ibexa/commerce-shop|Main shop functionalities **deprecated** |

## [[= product_name_exp =]] packages

|Bundle|Description|
|---------|-----------|
|ibexa/headless|Metapackage for Symfony Flex-based [[= product_name =]] Headless installation|
|ibexa/corporate-account|Customer portal and corporate accounts|
|ibexa/fieldtype-address|Address handling field type|
|ibexa/form-builder|Enables creating Form content items with multiple form fields|
|ibexa/page-builder|Page editor|
|ibexa/fieldtype-page|Page handling field type|
|ibexa/permissions|Additional permission functionalities|
|ibexa/segmentation|Segment functionality for profiling the content displayed to specific users|
|ibexa/site-factory|Enables configuration of sites from UI|
|ibexa/connector-seenthis|Enables displaying video with exceeded standard video restrictions|
|ibexa/connector-qualifio|Enables integration with [Qualifio Engage platform](https://developers.qualifio.com/docs/engage/)|


## [[= product_name_com =]] packages

|Bundle|Description|
|---------|-----------|
|ibexa/experience|Metapackage for Symfony Flex-based [[= product_name =]] Experience installation|
|ibexa/cart|Main store functionalities|
|ibexa/checkout|Store checkout functionality|
|ibexa/storefront|A storefront starting kit|
|ibexa/order-management|Order management|
|ibexa/payment|Payment handling|
|ibexa/shipping|Shipping handling|
|ibexa/commerce-admin-ui|Shop-related back office functionalities **deprecated** |
|ibexa/commerce-erp-admin|ERP connection for the shop **deprecated** |
|ibexa/commerce-order-history|Order history functionality **deprecated** |
|ibexa/commerce-page-builder|Shop-related Page blocks **deprecated** |
|ibexa/commerce-transaction|Transactional shop functionalities **deprecated** |
