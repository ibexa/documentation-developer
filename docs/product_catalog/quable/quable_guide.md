---
description: The Quable product guide describes how you can use the product data from Quable in Ibexa DXP to create marketing campaigns built around your products.
month_change: false
---

# Quable product guide

## Overview

[[= pim_product_name =]] integration connects [[= product_name =]] with [[[= pim_product_name =]] Product Information Management (PIM)](https://www.quable.com/en), making [[= pim_product_name =]] the authoritative source of product information for every website powered by [[= product_name =]].

[[= pim_product_name =]] serves as the single source of truth for all product data, including attributes, classifications, variants, and translations.
[[= product_name =]] consumes this data and makes it available for use in content and digital experiences.

This approach eliminates the need to manage product data in multiple systems, while preserving a clear separation of responsibilities between product management and content usage.

## Availability

The integration with [[= pim_product_name =]] PIM is available as an add-on for all [[= product_name =]] editions, starting with [[= product_name =]] v5.0.7.

Before installing and enabling the add-on, ensure that you have an active [[= pim_product_name =]] PIM instance with defined products, classifications, and channels.

Then, [perform the initial configuration](install_quable.md).

## How does [[= pim_product_name =]] integration work

The integration is built on [[= product_name =]]'s [Remote PIM framework](add_remote_pim_support.md), which enables connection to external product data sources.

Once configured, the system performs:

- an initial synchronization of product data from Quable
- ongoing updates via webhooks (near real-time)

Product data is mapped to the [[= product_name =]]'s product data model, including variants, attributes and [product categories](product_catalog_guide.md#product-taxonomy).

This data is then available in the back office, content editing tools like [Online Editor](online_editor_guide.md) and [Page Builder](page_builder_guide.md), and APIs.

All product management operations remain handled in [[= pim_product_name =]].

[[= product_name =]] can be used to manage pricing and availability for products sourced from [[= pim_product_name =]], including support for market-specific configurations such as regions and currencies.

## Capabilities

### Single source of truth

[[= pim_product_name =]] is the authoritative system for product data, including attributes, classifications, variants, and translations.


[[= product_name =]] consumes this data and makes it available for use within content and back office interfaces, enabling editorial teams to enrich content by reusing product information.

## Use cases

### Multi-market operations

A retailer operating across multiple markets can manage product data in [[= pim_product_name =]] using channels and localized languages.
[[= product_name =]] connects to the relevant channel and makes localized product information available for use in content and back office interfaces, ensuring consistency across markets from a single [[= pim_product_name =]] instance.

## Faster campaign execution

Product data defined in [[= pim_product_name =]] can be immediately used in [[= product_name =]] for building content and campaigns.
Marketing teams can create pages and enrich content using up-to-date product information, without the need to duplicate or manually synchronize data.

## Known limitations

The integration with [[= pim_product_name =]] has the following known limitations:

- It's not compatible with [Commerce](commerce.md) functionalities. [Carts](cart.md), [order management](order_management.md), and [shopping lists](shopping_list.md) can't be used with products coming from [[= pim_product_name =]].
- [Catalogs](product_catalog_guide.md#catalogs) can't be created from [[= pim_product_name =]] products.
- [Product assets](product_catalog_guide.md#product-assets) are not fully synchronized. Only the main product thumbnail from [[= pim_product_name =]] is used.
- [Product-level access restrictions](policies.md#products) based on product type are not supported.
- You can't define prices and availability for products with product codes exceeding 64 characters.
