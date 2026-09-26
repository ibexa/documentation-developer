# Bundles

Ibexa DXP is composed of bundles containing different parts of the application.

A bundle in Symfony (and Ibexa DXP) is a separate part of your application that implements a feature. You can [create bundles yourself](../../../resources/contributing/package_structure/index.md) or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many Ibexa DXP functionalities are provided through separate bundles included in the installation. You can see the bundles that are automatically installed with Ibexa DXP in the respective `composer.json` files. For example, for Ibexa Headless, see the [JSON file on GitHub](https://github.com/ibexa/headless/blob/5.0/composer.json).

## Working with bundles

All bundles containing built-in Ibexa DXP functionalities are installed automatically. Additionally, you can install community-developed bundles from [Ibexa DXP Packages.](https://developers.ibexa.co/packages)

To learn how to create your own bundles, see [Symfony documentation on bundles](https://symfony.com/doc/7.4/bundles.html).

### Overriding third-party bundles

When you use an external bundle, you can override its parts, such as templates or controllers. To do so, make use of [Symfony's bundle override mechanism](https://symfony.com/doc/7.4/bundles/override.html). When overriding files, the path inside your application has to correspond to the path inside the bundle.

### Removing bundles

To remove a bundle (either one you created yourself, or an out-of-the-box one that you don't need), remove the bundle entry from `config/bundles.php`.

## Core packages

> **Tip: Tip**
>
> Ibexa Open Source is composed of the core packages.

| Bundle                                                                  | Description                                                                                                                                                 |
| ----------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [ibexa/admin-ui](https://github.com/ibexa/admin-ui)                     | Back office interface                                                                                                                                       |
| [ibexa/admin-ui-assets](https://github.com/ibexa/admin-ui-assets)       | Assets for the back office                                                                                                                                  |
| [ibexa/content-forms](https://github.com/ibexa/content-forms)           | Form-based integration for the Symfony Forms into content and user objects in kernel                                                                        |
| [ibexa/core](https://github.com/ibexa/core)                             | Core of the Ibexa DXP application                                                                                                                           |
| [ibexa/core-search](https://github.com/ibexa/core-search)               | Search-related capabilities                                                                                                                                 |
| [ibexa/core-persistence](https://github.com/ibexa/core-persistence)     | Core system persistence                                                                                                                                     |
| [ibexa/cron](https://github.com/ibexa/cron)                             | Cron package for use with the `ibexa:cron:run` command                                                                                                      |
| [ibexa/design-engine](https://github.com/ibexa/design-engine)           | [Design fallback system](../../../templating/design_engine/design_engine/index.md)                                                       |
| [ibexa/doctrine-schema](https://github.com/ibexa/doctrine-schema)       | Basic abstraction layer for cross-DBMS schema import                                                                                                        |
| [ibexa/fieldtype-matrix](https://github.com/ibexa/fieldtype-matrix)     | [Matrix field type](../../../content_management/field_types/field_type_reference/matrixfield/index.md)                                   |
| [ibexa/fieldtype-query](https://github.com/ibexa/fieldtype-query)       | [Query field type](../../../content_management/field_types/field_type_reference/contentqueryfield/index.md)                              |
| [ibexa/fieldtype-richtext](https://github.com/ibexa/fieldtype-richtext) | field type for supporting rich-formatted text stored in a structured XML format                                                                             |
| [ibexa/graphql](https://github.com/ibexa/graphql)                       | GraphQL server for Ibexa DXP                                                                                                                                |
| [ibexa/http-cache](https://github.com/ibexa/http-cache)                 | [HTTP cache handling](../../../infrastructure_and_maintenance/cache/http_cache/http_cache/index.md), using multi tagging                 |
| [ibexa/i18n](https://github.com/ibexa/i18n)                             | Centralized translations to ease synchronization with Crowdin                                                                                               |
| [ibexa/messenger](https://github.com/ibexa/messenger)                   | [Background and asynchronous task processing](../../../infrastructure_and_maintenance/background_tasks/index.md) using Symfony Messenger |
| [ibexa/notifications](https://github.com/ibexa/notifications)           | Sending [notifications to channels](../../../api/notification_channels/index.md)                                                         |
| [ibexa/post-install](https://github.com/ibexa/post-install)             | Apache and nginx templates                                                                                                                                  |
| [ibexa/rest](https://github.com/ibexa/rest)                             | REST API                                                                                                                                                    |
| [ibexa/search](https://github.com/ibexa/search)                         | Common search functionalities                                                                                                                               |
| [ibexa/solr](https://github.com/ibexa/solr)                             | [Solr-powered](https://solr.apache.org/) search handler                                                                                                     |
| [ibexa/standard-design](https://github.com/ibexa/standard-design)       | Standard design and theme to be handled by `design-engine`                                                                                                  |
| [ibexa/system-info](https://github.com/ibexa/system-info)               | Information about the system Ibexa DXP is running on                                                                                                        |
| [ibexa/twig-components](https://github.com/ibexa/twig-components)       | [Twig Components](../../../templating/components/index.md)                                                                               |
| [ibexa/user](https://github.com/ibexa/user)                             | User management                                                                                                                                             |

## Ibexa Headless packages

| Bundle                                    | Description                                                                                                                                                                                                                       |
| ----------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| ibexa/oss                                 | Core packages                                                                                                                                                                                                                     |
| ibexa/app-switcher                        | Integration with the [QNTM group](https://qntmgroup.com/solutions/)                                                                                                                                                               |
| ibexa/calendar                            | Calendar tab with a calendar widget                                                                                                                                                                                               |
| ibexa/collaboration                       | Collaboration functionality                                                                                                                                                                                                       |
| ibexa/connect                             | [Ibexa Connect](https://doc.ibexa.co/projects/connect/en/latest/)                                                                                                                                                                 |
| ibexa/connector-ai                        | Foundation for the [AI Actions](../../../ai/ai_actions/ai_actions/index.md) framework                                                                                                                          |
| ibexa/connector-dam                       | Connector for DAM (Digital Asset Management) systems                                                                                                                                                                              |
| ibexa/connector-openai                    | Integrates the AI framework with [OpenAI](https://openai.com)                                                                                                                                                                     |
| ibexa/content-tree                        | Content tree functionality                                                                                                                                                                                                        |
| ibexa/elasticsearch                       | Integration with Elasticsearch search engine                                                                                                                                                                                      |
| ibexa/fastly                              | Fastly support for `http-cache`, for use on Ibexa Cloud or standalone                                                                                                                                                             |
| ibexa/headless-assets                     | Assets for the back office                                                                                                                                                                                                        |
| ibexa/icons                               | Icon set for the back office                                                                                                                                                                                                      |
| ibexa/image-editor                        | [Image Editor](../../../content_management/images/configure_image_editor/index.md)                                                                                                                             |
| ibexa/installer                           | Provides the `ibexa:install` command                                                                                                                                                                                              |
| ibexa/measurement                         | Measurement field type and measurement product catalog attribute                                                                                                                                                                  |
| ibexa/migrations                          | [Migration of repository data](../../../content_management/data_migration/data_migration/index.md)                                                                                                             |
| ibexa/oauth2-client                       | Authenticate user through a [third-party OAuth 2 server](../../../users/oauth_client/index.md), integration with [`knpuniversity/oauth2-client-bundle`](https://github.com/knpuniversity/oauth2-client-bundle) |
| ibexa/oauth2-server                       | Configure Ibexa DXP to act as a [OAuth2 Server](../../../users/oauth_server/index.md)                                                                                                                          |
| ibexa/product-catalog-date-time-attribute | Implementation of the [Date and Time attribute type](../../../product_catalog/attributes/date_and_time/index.md)                                                                                               |
| ibexa/product-catalog-symbol-attribute    | Implementation of the [Symbol attribute type](../../../product_catalog/attributes/symbol_attribute_type/index.md)                                                                                              |
| ibexa/product-catalog                     | Product catalog functionality                                                                                                                                                                                                     |
| ibexa/scheduler                           | Date-based publishing functionality                                                                                                                                                                                               |
| ibexa/seo                                 | Search Engine Optimization (SEO) tool                                                                                                                                                                                             |
| ibexa/share                               | Content-sharing functionality                                                                                                                                                                                                     |
| ibexa/taxonomy                            | Taxonomy functionality                                                                                                                                                                                                            |
| ibexa/tree-builder                        | Tree builder functionality                                                                                                                                                                                                        |
| ibexa/version-comparison                  | Enables comparing between two versions of the same field                                                                                                                                                                          |
| ibexa/workflow                            | Collaboration feature that enables you to send content draft to any user for a review or rewriting                                                                                                                                |

## Ibexa Experience packages

| Bundle                  | Description                                                                                                 |
| ----------------------- | ----------------------------------------------------------------------------------------------------------- |
| ibexa/headless          | Metapackage for Symfony Flex-based Ibexa DXP Headless installation                                          |
| ibexa/activity-log      | Customer portal and corporate accounts                                                                      |
| ibexa/corporate-account | Customer portal and corporate accounts                                                                      |
| ibexa/dashboard         | [Customizable dashboard](../../dashboard/customize_dashboard/index.md) |
| ibexa/fieldtype-address | Address handling field type                                                                                 |
| ibexa/form-builder      | Enables creating Form content items with multiple form fields                                               |
| ibexa/page-builder      | Page editor                                                                                                 |
| ibexa/fieldtype-page    | Page handling field type                                                                                    |
| ibexa/permissions       | Additional permission functionalities                                                                       |
| ibexa/segmentation      | Segment functionality for profiling the content displayed to specific users                                 |
| ibexa/site-factory      | Enables configuration of sites from UI                                                                      |
| ibexa/engage            | Enables integration with [Qualifio Engage platform](https://developers.qualifio.com/docs/engage/)           |

## Ibexa Commerce packages

| Bundle                                  | Description                                                                                                                              |
| --------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| ibexa/experience                        | Metapackage for Symfony Flex-based Ibexa DXP Experience installation                                                                     |
| ibexa/cart                              | Main store functionalities                                                                                                               |
| ibexa/checkout                          | Store checkout functionality                                                                                                             |
| ibexa/corporate-account-commerce-bridge | Additional functionality for [corporate accounts](../../admin_panel/corporate_admin_panel/index.md) |
| ibexa/discounts                         | Adds [discounts](../../../discounts/discounts/index.md) functionality                                                 |
| ibexa/discounts-codes                   | Adds the possibility to use discount codes with the [Discounts](../../../discounts/discounts/index.md) functionality  |
| ibexa/storefront                        | A storefront starting kit                                                                                                                |
| ibexa/order-management                  | Order management                                                                                                                         |
| ibexa/payment                           | Payment handling                                                                                                                         |
| ibexa/shipping                          | Shipping handling                                                                                                                        |
| ibexa/connector-payum                   | [Payum integration](../../../commerce/payment/payum_integration/index.md)                                             |

## Optional packages

The following packages are optional and can be installed independently.

| Bundle                                                                        | Description                                                                                                                                         |
| ----------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- |
| [ibexa/automated-translation](https://github.com/ibexa/automated-translation) | Automated translation of content using [Google Translate or DeepL](../../../multisite/languages/automated_translations/index.md) |
| ibexa/cdp                                                                     | Integration with the [Customer Data Platform](../../../cdp/cdp/index.md)                                                         |
| [ibexa/cloud](https://github.com/ibexa/cloud)                                 | Integration with [Ibexa Cloud](../../../ibexa_cloud/ibexa_cloud/index.md)                                                        |

In addition, you can extend the capabilities of your project by installing additional [LTS Updates](../../../ibexa_products/editions/index.md#lts-updates).
