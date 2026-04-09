---
description: The Quable product guide describes how you can use the product data from Quable in Ibexa DXP to create marketing campaigns built around your products.
month_change: true
---

# Quable product guide

## What is [[= pim_product_name =]] integration

[[= pim_product_name =]] integration connects [[= product_name =]] with [[[= pim_product_name =]] Product Information Management (PIM)](https://www.quable.com/en), making [[= pim_product_name =]] the authoritative source of product information for every website powered by [[= product_name =]].

Store managers can manage their product catalog in [[= pim_product_name =]], creating product classification, managing attributes, and translating them.
At the same time, [[= product_name =]] can automatically receive that data and make it available for building digital experiences: storefronts, landing pages, personalized campaigns, and more.

The integration complements the native [Product catalog](product_catalog_guide.md) by replacing local product storage with [[= pim_product_name =]].
Instead of maintaining product data in two places, teams manage it once and distribute it everywhere.

## Availability

Integration with [[= pim_product_name =]] PIM is available in all [[= product_name =]] editions, starting with [[= product_name =]] v5.0.7.

Before installing and enabling the integration, ensure that you have an active [[= pim_product_name =]] PIM instance with defined products, classifications, and channels.

Then, [perform the initial configuration](install_quable.md).

## How does [[= pim_product_name =]] integration work

[[= pim_product_name =]] acts as the single source of truth for product information.
The [[= pim_product_name =]] integration is built on [[= product_name =]]'s [Remote PIM framework](add_remote_pim_support.md), which provides a foundation for connecting external PIM systems to the DXP.

The system synchronizes the data from [[= pim_product_name =]] to [[= product_name =]] and represents it using the built-in [product catalog data model](product_catalog_guide.md#how-does-product-catalog-work).
The data can then be displayed in storefronts, back office views, and API responses.

[Product categories](product_catalog_guide.md#product-taxonomy) are also synchronized from [[= pim_product_name =]] into [[= product_name =]], allowing you to reuse the existing channel classifications in [[= product_name =]].

## Capabilities

### Single source of product truth

[[= pim_product_name =]] is the authoritative system for product data.
Product management, such as adding attributes and translations, is done in [[= pim_product_name =]].
[[= product_name =]] consumes this enriched data and exposes it through storefronts, back office, and APIs.

Editorial teams that need to add DXP-specific content, such as promotional text or page layout, can still do so by reusing the product data, for example by using the [Online Editor](online_editor_guide.md#product-marketing-campaigns) and workflows including [collaborative editing](collaborative_editing_guide.md).

### Products, variants, and categories

[[= pim_product_name =]] product types map to [[= product_name =]] product types, and [[= pim_product_name =]] product variants are exposed as [[= product_name =]] product variants.

[[= pim_product_name =]]'s [product classifications](https://docs.quable.com/v5-EN/docs/documents-classification-new-version) are synchronized into [[= product_name =]]'s taxonomy, using product categories to organize products into structures.

### Prices, availability, and market context

You can use [[= product_name =]] to manage product availability and pricing for [[= pim_product_name =]]'s products, including creating advanced pricing strategies with [discounts](discounts.md) combined with [regions](product_catalog_guide.md#regions) and [currencies](product_catalog_guide.md#currencies).

## Use cases

### Multi-market channel operations

A retailer operating in multiple European markets can maintain a single product catalog in [[= pim_product_name =]] with separate channels and data languages per market.
[[= product_name =]] connects to each market's channel and serves localized product names and descriptions to each regional storefront, all from a single [[= pim_product_name =]] instance.

### Faster marketing launches

A fashion brand's store manager can add a new seasonal collection in [[= pim_product_name =]] to a dedicated channel.
The marketing team can then immediately start working on their campaign within [[= product_name =]], using the product data from [[= pim_product_name =]] both in [Page Builder](page_builder_guide.md) and regular content items.

## Known limitations

The integration with [[= pim_product_name =]] has the following known limitations:

- It's not compatible with [Commerce](commerce.md) functionalities. [Carts](cart.md), [order management](order_management.md), and [shopping lists](shopping_list.md) can't be used with products coming from [[= pim_product_name =]].
- It's not possible to create [catalogs](product_catalog_guide.md#catalogs) with products coming from [[= pim_product_name =]].
- Product assets are not synchronized. Only the main asset thumbnail URL from [[= pim_product_name =]] is used as the product image. Asset collections, asset management, and variant thumbnails are not available.
- It's not possible to limit access to products using the existing [`ProductType` product limitations](policies.md#products).
- It's not possible to synchronize products with the `/` symbol in the product code, or with product codes longer than 64 characters.
