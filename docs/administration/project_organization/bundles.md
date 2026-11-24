---
description: Cohesivo is composed of bundles containing different parts of the application.
page_type: reference
---

# Bundles

A bundle in Symfony (and [[= product_name =]]) is a separate part of your application that implements a feature.
You can [create bundles yourself](package_structure.md) or make use of available open-source bundles.
You can also reuse the bundles you create in other projects or share them with the community.

Many [[= product_name =]] functionalities are provided through separate bundles included in the installation.
You can see the bundles that are automatically installed with [[= product_name =]] in the respective `composer.json` files.
For example, for [[= product_name =]], see the [JSON file on GitHub](https://github.com/ibexa/cohesivo/blob/6.0/composer.json).

## Working with bundles

All bundles containing built-in [[= product_name =]] functionalities are installed automatically.
Additionally, you can install community-developed bundles from [[[= product_name =]] Packages.](https://developers.ibexa.co/packages)

To learn how to create your own bundles, see [Symfony documentation on bundles]([[= symfony_doc =]]/bundles.html).

### Overriding third-party bundles

When you use an external bundle, you can override its parts, such as templates or controllers.
To do so, make use of [Symfony's bundle override mechanism]([[= symfony_doc =]]/bundles/override.html).
When overriding files, the path inside your application has to correspond to the path inside the bundle.

### Removing bundles

To remove a bundle (either one you created yourself, or an out-of-the-box one that you don't need), remove the bundle entry from `config/bundles.php`.

## [[= product_name =]] packages

|Bundle|Description|
|---------|-----------|
|ibexa/cohesivo|Metapackage for Symfony Flex-based [[= product_name =]] installation|
|ibexa/activity-log|Customer portal and corporate accounts|
|[ibexa/admin-ui](https://github.com/ibexa/admin-ui)|Back office interface|
|[ibexa/admin-ui-assets](https://github.com/ibexa/admin-ui-assets)|Assets for the back office|
|ibexa/app-switcher|Integration with the [QNTM group](https://ibexa.ai/en/about-ibexa/governance)|
|ibexa/calendar|Calendar tab with a calendar widget|
|ibexa/collaboration|Collaboration functionality|
|ibexa/connect|[[[= product_name_connect =]]]([[= connect_doc =]]/)|
|ibexa/connector-ai|Foundation for the [AI Actions](ai_actions.md) framework|
|ibexa/connector-dam|Connector for DAM (Digital Asset Management) systems|
|ibexa/connector-openai|Integrates the AI framework with [OpenAI](https://openai.com) |
|[ibexa/content-forms](https://github.com/ibexa/content-forms)|Form-based integration for the Symfony Forms into content and user objects in kernel|
|ibexa/content-tree|Content tree functionality|
|[ibexa/core](https://github.com/ibexa/core)|Core of the [[= product_name =]] application|
|[ibexa/core-persistence](https://github.com/ibexa/core-persistence)|Core system persistence|
|[ibexa/core-search](https://github.com/ibexa/core-search)|Search-related capabilities|
|ibexa/corporate-account|Customer portal and corporate accounts|
|[ibexa/cron](https://github.com/ibexa/cron)|Cron package for use with the `ibexa:cron:run` command|
|ibexa/dashboard|[Customizable dashboard](customize_dashboard.md)|
|[ibexa/design-engine](https://github.com/ibexa/design-engine)|[Design fallback system](design_engine.md)|
|[ibexa/doctrine-schema](https://github.com/ibexa/doctrine-schema)| Basic abstraction layer for cross-DBMS schema import|
|ibexa/elasticsearch|Integration with Elasticsearch search engine|
|ibexa/fastly|Fastly support for `http-cache`, for use on [[= product_name_cloud =]] or standalone|
|ibexa/fieldtype-address|Address handling field type|
|[ibexa/fieldtype-matrix](https://github.com/ibexa/fieldtype-matrix)|[Matrix field type](matrixfield.md)|
|ibexa/fieldtype-page|Page handling field type|
|[ibexa/fieldtype-query](https://github.com/ibexa/fieldtype-query)|[Query field type](contentqueryfield.md)|
|[ibexa/fieldtype-richtext](https://github.com/ibexa/fieldtype-richtext)|field type for supporting rich-formatted text stored in a structured XML format|
|ibexa/form-builder|Enables creating Form content items with multiple form fields|
|[ibexa/graphql](https://github.com/ibexa/graphql)|GraphQL server for [[= product_name =]]|
|ibexa/headless-assets|Assets for the back office|
|[ibexa/http-cache](https://github.com/ibexa/http-cache)|[HTTP cache handling](http_cache.md), using multi tagging|
|[ibexa/i18n](https://github.com/ibexa/i18n)|Centralized translations to ease synchronization with Crowdin|
|ibexa/icons|Icon set for the back office|
|ibexa/image-editor|[Image Editor](configure_image_editor.md)|
|ibexa/installer|Provides the `ibexa:install` command|
|ibexa/integrated-help|[Integrated help](integrated_help.md) and [product tour](product_tour.md) in the back office|
|ibexa/mcp|[MCP servers](mcp.md)|
|ibexa/measurement|Measurement field type and measurement product catalog attribute|
|[ibexa/messenger](https://github.com/ibexa/messenger)|[Background and asynchronous task processing](background_tasks.md) using Symfony Messenger|
|ibexa/migrations|[Migration of repository data](data_migration.md)|
|[ibexa/notifications](https://github.com/ibexa/notifications)| Sending [notifications to channels](notification_channels.md)|
|ibexa/oauth2-client|Authenticate user through a [third-party OAuth 2 server](oauth_client.md), integration with [`knpuniversity/oauth2-client-bundle`](https://github.com/knpuniversity/oauth2-client-bundle)|
|ibexa/page-builder|Page editor|
|ibexa/permissions|Additional permission functionalities|
|[ibexa/post-install](https://github.com/ibexa/post-install)|Apache and nginx templates|
|ibexa/product-catalog|Product catalog functionality|
|ibexa/product-catalog-date-time-attribute|Implementation of the [Date and Time attribute type](date_and_time.md)|
|ibexa/product-catalog-symbol-attribute|Implementation of the [Symbol attribute type](symbol_attribute_type.md)|
|[ibexa/rest](https://github.com/ibexa/rest)|REST API|
|ibexa/scheduler|Date-based publishing functionality|
|[ibexa/search](https://github.com/ibexa/search)|Common search functionalities|
|ibexa/segmentation|Segment functionality for profiling the content displayed to specific users|
|ibexa/seo|Search Engine Optimization (SEO) tool|
|ibexa/share|Content-sharing functionality|
|ibexa/site-factory|Enables configuration of sites from UI|
|[ibexa/solr](https://github.com/ibexa/solr)|[Solr-powered](https://solr.apache.org/) search handler|
|[ibexa/standard-design](https://github.com/ibexa/standard-design)|Standard design and theme to be handled by `design-engine`|
|[ibexa/system-info](https://github.com/ibexa/system-info)| Information about the system [[= product_name =]] is running on|
|ibexa/taxonomy|Taxonomy functionality|
|ibexa/translations-management|[Translations management](translations_management.md)|
|ibexa/tree-builder|Tree builder functionality|
|[ibexa/twig-components](https://github.com/ibexa/twig-components)| [Twig Components](components.md)|
|[ibexa/user](https://github.com/ibexa/user)|User management|
|ibexa/version-comparison|Enables comparing between two versions of the same field|
|ibexa/workflow|Collaboration feature that enables you to send content draft to any user for a review or rewriting|

## [[= product_name_commerce_sdk =]] packages

The following packages are installed with the [[= product_name_commerce_sdk =]].

|Bundle|Description|
|---------|-----------|
|ibexa/cohesivo-commerce-sdk|Metapackage for [installing [[= product_name_commerce_sdk =]]](../../commerce/install_commerce_sdk.md)|
|ibexa/cart|Main store functionalities|
|ibexa/checkout|Store checkout functionality|
|ibexa/corporate-account-commerce-bridge|Additional functionality for [corporate accounts](corporate_admin_panel.md)|
|ibexa/discounts|Adds [discounts](discounts.md) functionality|
|ibexa/discounts-codes|Adds the possibility to use discount codes with the [Discounts](discounts.md) functionality|
|ibexa/storefront|A storefront starting kit|
|ibexa/order-management|Order management|
|ibexa/payment|Payment handling|
|ibexa/shipping|Shipping handling|
|ibexa/connector-payum|[Payum integration](payum_integration.md)|
|ibexa/shopping-list|[Shopping list](shopping_list.md) functionality|

## Add-ons

The following [add-ons](cohesivo_products.md#add-ons) are optional and can be installed independently.

|Bundle|Description|
|---------|-----------|
|ibexa/async-content-publishing|Asynchronous content publishing|
|ibexa/cdp|Integration with [[[= product_name_cdp =]]](../../raptor_cdp/raptor_cdp.md)|
|[ibexa/cloud](https://github.com/ibexa/cloud)|Integration with [[[= product_name_cloud =]]](/ibexa_cloud/ibexa_cloud.md)|
|ibexa/connector-actito|[Transactional emails](transactional_emails.md) through Actito|
|ibexa/connector-quable|Integration with [[[= pim_product_name =]]](../../product_catalog/quable/quable.md)|
|ibexa/connector-raptor|[Raptor connector](raptor_connector_guide.md) for recommendations|
|ibexa/connector-seenthis|Integration with SeenThis!|
|ibexa/connector-unsplash|[Unsplash](add_image_asset_from_dam.md) image connector|
|ibexa/engage|Enables integration with [[[= product_name_engage =]]](https://developers.qualifio.com/docs/engage/)|
|ibexa/mercure|Integration with Mercure|
|ibexa/oauth2-server|Configure [[= product_name =]] to act as a [OAuth2 Server](oauth_server.md)|

In addition, you can extend the capabilities of your project by installing [LTS Updates](cohesivo_products.md#lts-updates).
