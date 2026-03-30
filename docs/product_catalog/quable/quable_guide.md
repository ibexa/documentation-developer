---
description: The Quable product guide describes how you can use the product data from Quable in Ibexa DXP to create marketing campaigns built around your products.
month_change: false
---

# Quable product guide

TODO: known limitations - `/` in product code i policies

## What is [[= pim_product_name =]] integration

[[= pim_product_name =]] integration connects [[= product_name =]] with [[[= pim_product_name =]] PIM](https://www.quable.com/en), making [[= pim_product_name =]] the authoritative source of product information for every channel powered by [[= product_name =]].

Store managers can manage their product catalog in [[= pim_product_name =]] — creating product families, managing attributes, uploading assets, and translating content — while [[= product_name =]] automatically receives that data and makes it available for digital experiences: storefronts, landing pages, personalized campaigns, and more.

The integration complements the native [Product Catalog](../product_catalog_guide.md) by replacing local product storage with a live connection to [[= pim_product_name =]].
Instead of maintaining product data in two places, teams manage it once and distribute it everywhere.

## Availability

Product Catalog capabilities are available in all [[= product_name =]] editions, starting with [[= product_name =]] v5.0.7.

Before installing and enabling the integration, ensure that you have an active [[= pim_product_name =]] PIM instance with products and product families configured.

Then, [perform the initial configuration](install_quable.md).

## How does Quable integration work

[[= pim_product_name =]] acts as the single source of truth for product information.
The [[= pim_product_name =]] integration is built on [[= product_name =]]'s [Remote PIM framework](add_remote_pim_support.md), which provides a foundation for connecting external Product Information Management systems to the DXP.
To read product data, [[= product_name =]] fetches it from [[= pim_product_name =]].
A configurable cache layer keeps response times low.

The system represents the product data using the built-in [product catalog data model](product_catalog_guide.md#how-does-product-catalog-work).
The data can then be displayed in storefronts, back office views, or API responses.

[Product categories](product_catalog_guide.md#product-taxonomy) are synchronized from [[= pim_product_name =]] into [[= product_name =]], allowing you to reuse the existing channel classifications in [[= product_name =]].

## Capabilities

### Product enrichment and governance

[[= pim_product_name =]] is the authoritative system for product data.
All product enrichment — adding attributes, translations, editorial copy, and digital assets — is done in [[= pim_product_name =]].
[[= product_name =]] consumes this enriched data and exposes it through storefronts, back office, and APIs.

Editorial teams that need to add DXP-specific content, such as promotional text or page layout, can still do so by enriching the product's underlying content item in [[= product_name =]] using the [Online Editor](../../content_management/rich_text/online_editor_guide.md) and workflows including [collaborative editing](../../content_management/collaborative_editing/collaborative_editing_guide.md).

### Variants, categories, and catalogs

[[= pim_product_name =]] product families map to [[= product_name =]] product types, and [[= pim_product_name =]] product variants are exposed as [[= product_name =]] product variants, following the [[= pim_product_name =]] model.

[[= pim_product_name =]]'s [product classifications](https://docs.quable.com/v5-EN/docs/documents-classification-new-version) are synchronized into [[= product_name =]]'s taxonomy, enabling product categories to be used as filter criteria when building [catalogs](../product_catalog_guide.md#catalogs).
Catalogs can be created and managed in [[= product_name =]] using product types, attributes, availability, and categories as filter criteria, the same as with the native Product Catalog.

### Prices, availability, and market context

Pricing and availability data management depends on your project configuration.
[[= product_name =]] provides extension points for pricing and availability that can be connected to [[= pim_product_name =]] or to an external ERP or pricing system.
By default, [[= product_name =]]'s local pricing and availability mechanisms apply.
For market-specific pricing, configure [regions and currencies](../product_catalog_guide.md#regions) as needed.

## Benefits

### Single source of product truth

By using [[= pim_product_name =]] as the product data source, teams manage product information once and distribute it everywhere — storefronts, APIs, campaigns — without manual duplication or data drift between systems.

### Faster catalog updates and time to market

Real-time webhook synchronization means that product updates made in [[= pim_product_name =]] are immediately reflected in [[= product_name =]] experiences.
Seasonal launches, new product introductions, and product updates reach customers faster.

### Better data consistency across channels

Channel-scoped product data in [[= pim_product_name =]] ensures that each market and storefront receives the correct attribute values, translations, and assets.
[[= product_name =]]'s multi-site and multi-language capabilities work in concert with [[= pim_product_name =]]'s channel and data-language model.

### Reduced manual merchandising effort

Automated classification synchronization and webhook-driven cache invalidation eliminate manual catalog refresh operations.
Merchandising teams can focus on content and campaign strategy rather than data maintenance.

### Extensible and DXP-integrated

The integration plugs into [[= product_name =]]'s standard product catalog interfaces.
Existing DXP features — [Personalization](../../personalization/personalization_guide.md), [Page Builder](../../content_management/pages/page_builder_guide.md) blocks, [Customer Portal](../../customer_management/customer_portal_guide.md) product pages, shopping lists, and discounts — work with [[= pim_product_name =]]-sourced product data without modification.

## Use cases

### Multi-market catalog operations

A retailer operating in multiple European markets maintains a single product catalog in [[= pim_product_name =]] with separate channels and data languages per market.
[[= product_name =]] connects to each market's channel and serves localized product names, descriptions, and market-specific assets to each regional storefront — all from a single [[= pim_product_name =]] instance.

### Faster seasonal launches

A fashion brand adds a new seasonal collection in [[= pim_product_name =]] with attributes, variants, and assets.
The webhook integration ensures that [[= product_name =]] reflects the new products and classification changes within minutes.
The marketing team publishes campaign pages in [Page Builder](../../content_management/pages/page_builder_guide.md) referencing the newly available products, going live without waiting for a manual data sync.

### Centralized product governance

A manufacturer with a complex product portfolio keeps all technical and marketing product data in [[= pim_product_name =]], where governance workflows, completeness rules, and approval processes ensure data quality.
[[= product_name =]] consumes this validated data, presenting it to B2B customers through the [Customer Portal](../../customer_management/customer_portal_guide.md) and powering [Personalization](../../personalization/personalization_guide.md) scenarios with accurate, up-to-date product information.

## Related documentation

- [Install [[= pim_product_name =]] connector](install_quable.md)
- [Configure [[= pim_product_name =]] connector](configure_quable_connector.md)
- [Quable Twig functions](../../templating/twig_function_reference/quable_twig_functions.md)
- [Product Catalog guide](../product_catalog_guide.md)
- [Remote PIM support](../add_remote_pim_support.md)
- [Background tasks](../../infrastructure_and_maintenance/background_tasks.md)
- [Persistence cache](../../infrastructure_and_maintenance/cache/persistence_cache.md)
- [Security checklist](../../infrastructure_and_maintenance/security/security_checklist.md)
- [Quable documentation](https://docs.quable.com/)
- [Quable technical documentation](https://developers.quable.com/)
