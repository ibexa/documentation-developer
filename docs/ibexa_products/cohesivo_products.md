---
description: Learn about Cohesivo, the Commerce SDK, LTS Updates, and add-ons, and the features that each of them brings.
page_type: landing_page
---

# [[= product_name =]] products

[[= product_name =]] is a content management system (CMS) that combines content management, customer experience, and product catalog capabilities in one package.
You can extend it with the [[= product_name_commerce_sdk =]] to build a complete e-commerce presence, and with optional [LTS Updates](#lts-updates) and [add-ons](#add-ons).

[[= cards([
    "ibexa_products/cohesivo",
    "ibexa_products/commerce_sdk",
], columns=2) =]]

## Cohesivo feature list

[[= product_name =]] includes the following features.

| Area | Features |
|---|---|
| Content management | <ul><li>[Content model](content_model.md)</li><li>[Content translation]([[= user_doc =]]/content_management/translate_content/)</li><li>[Translations management](translations_management_guide.md)</li><li>[Editorial workflow]([[= user_doc =]]/content_management/workflow_management/editorial_workflow/)</li><li>[Content scheduling]([[= user_doc =]]/content_management/schedule_publishing/), including the [Scheduler tab]([[= user_doc =]]/content_management/schedule_publishing/#scheduler-tab) and the [Content Scheduler block]([[= user_doc =]]/content_management/schedule_publishing/#content-scheduler-block)</li><li>[Migrations](managing_migrations.md)</li><li>[Recent activity](recent_activity.md)</li></ul> |
| Page and form building | <ul><li>[Page Builder](page_builder_guide.md)</li><li>[Form Builder](form_builder_guide.md)</li><li>[Site Factory](site_factory.md)</li></ul> |
| Editorial experience | <ul><li>[Customizable Dashboard]([[= user_doc =]]/getting_started/dashboard/work_with_dashboard/#customize-dashboard)</li><li>[Focus Mode]([[= user_doc =]]/getting_started/discover_ui/#focus-mode)</li><li>[Image editor]([[= user_doc =]]/image_management/edit_images/)</li><li>[Digital Asset Management]([[= user_doc =]]/dam/ibexa_dam/)</li><li>[Integrated help](integrated_help.md)</li><li>[SEO]([[= user_doc =]]/search_engine_optimization/seo/)</li><li>[Search]([[= user_doc =]]/search/search_for_content/)</li></ul> |
| AI | <ul><li>[AI Actions](ai_actions_guide.md)</li><li>[MCP servers](mcp_guide.md)</li></ul> |
| Product catalog and customers | <ul><li>[Product catalog]([[= user_doc =]]/product_catalog/product_catalog/), including the [date and time](date_and_time.md) and [symbol](symbol_attribute_type.md) attribute types</li><li>[Corporate account management]([[= user_doc =]]/customer_management/manage_customers/)</li><li>[Customer Portal](customer_portal_guide.md)</li><li>[Segments](segments_admin_panel.md)</li></ul> |
| Users and integrations | <ul><li>[User management](user_management_guide.md)</li><li>[OAuth client](oauth_client.md)</li><li>[[[= product_name_connect =]]]([[= connect_doc =]]/)</li></ul> |

## [[= product_name_commerce_sdk =]] feature list

The [[= product_name_commerce_sdk =]] adds the following features to [[= product_name =]].

- [Cart](cart.md), including [Quick order](quick_order.md)
- [Checkout](checkout.md), including [Reorder](reorder.md)
- [Order management](order_management.md)
- [Payment](payment.md)
- [Shipping](shipping_management.md)
- [Storefront](storefront.md)
- [Discounts](discounts.md)
- [Shopping list](shopping_list.md)
- [Transactional emails](transactional_emails.md), with the [Actito connector add-on](#add-ons)

## LTS Updates

LTS Updates are opt-in packages that bring additional features to the [LTS releases](release_process_and_roadmap.md#long-term-support-releases) that they enhance.
The features brought by LTS Updates become standard parts of the next LTS release.

| LTS Update | Package |
|-----------------|-----------------|
| [Anthropic connector](configure_ai_actions.md#install-anthropic-connector) | `ibexa/connector-anthropic` |
| [Google Gemini connector](configure_ai_actions.md#install-google-gemini-connector) | `ibexa/connector-gemini` |

## Add-ons

While LTS Updates enhance the existing infrastructure vertically, add-ons allow for horizontal expansion by adding parallel capabilities to the [[= product_name =]] ecosystem.
They're designed to integrate with your platform, providing new functionalities that extend beyond the core [[= product_name =]] features.

| Add-on | Package |
|-----------------|-----------------|
| [Raptor connector](raptor_connector_guide.md) | `ibexa/connector-raptor` |
| [[[= product_name_cdp =]]](../raptor_cdp/raptor_cdp_guide.md) | `ibexa/cdp` |
| [[[= pim_product_name =]] connector](../product_catalog/quable/quable_guide.md) | `ibexa/connector-quable` |
| [[[= product_name_engage =]] connector](../qualifio/qualifio.md) | `ibexa/engage` |
| [Actito connector (transactional emails)](transactional_emails.md) | `ibexa/connector-actito` |
| [SeenThis! connector]([[= user_doc =]]/content_management/block_reference/#seenthis-block) | `ibexa/connector-seenthis` |
| [Unsplash connector](add_image_asset_from_dam.md) | `ibexa/connector-unsplash` |
| [[[= product_name_cloud =]]](../ibexa_cloud/ibexa_cloud_guide.md) | `ibexa/cloud` |
| [OAuth server](oauth_server.md) | `ibexa/oauth2-server` |
| Mercure | `ibexa/mercure` |
| Async content publishing | `ibexa/async-content-publishing` |
