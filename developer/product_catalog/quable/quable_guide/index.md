# Quable product guide

The Quable product guide describes how you can use the product data from Quable in Ibexa DXP to create marketing campaigns built around your products.

## Overview

Quable integration connects Ibexa DXP with [Quable Product Information Management (PIM)](https://www.quable.com/en), making Quable the authoritative source of product information for every website powered by Ibexa DXP.

Quable serves as the single source of truth for all product data, including attributes, classifications, variants, and translations. Ibexa DXP consumes this data and makes it available for use in content and digital experiences.

This approach eliminates the need to manage product data in multiple systems, while preserving a clear separation of responsibilities between product management and content usage.

## Availability

The integration with Quable PIM is available as an add-on for all Ibexa DXP editions, starting with Ibexa DXP v5.0.7.

Before installing and enabling the add-on, ensure that you have an active Quable PIM instance with defined products, classifications, and channels.

Then, [perform the initial configuration](../install_quable/index.md).

## How does Quable integration work

The integration is built on Ibexa DXP's [Remote PIM framework](../../add_remote_pim_support/index.md), which enables connection to external product data sources.

Once configured, the system performs:

- an initial synchronization of product data from Quable
- ongoing updates via webhooks (near real-time)

Product data is mapped to the Ibexa DXP's product data model, including variants, attributes and [product categories](../../product_catalog_guide/index.md#product-taxonomy).

This data is then available in the back office, content editing tools like [Online Editor](../../../content_management/rich_text/online_editor_guide/index.md) and [Page Builder](../../../content_management/pages/page_builder_guide/index.md), and APIs.

All product management operations remain handled in Quable.

Ibexa DXP can be used to manage pricing and availability for products sourced from Quable, including support for market-specific configurations such as regions and currencies.

## Capabilities

### Single source of truth

Quable is the authoritative system for product data, including attributes, classifications, variants, and translations.

Ibexa DXP consumes this data and makes it available for use within content and back office interfaces, enabling editorial teams to enrich content by reusing product information.

## Use cases

### Multi-market operations

A retailer operating across multiple markets can manage product data in Quable using channels and localized languages. Ibexa DXP connects to the relevant channel and makes localized product information available for use in content and back office interfaces, ensuring consistency across markets from a single Quable instance.

## Faster campaign execution

Product data defined in Quable can be immediately used in Ibexa DXP for building content and campaigns. Marketing teams can create pages and enrich content using up-to-date product information, without the need to duplicate or manually synchronize data.

## Known limitations

The integration with Quable has the following known limitations:

- It's not compatible with [Commerce](../../../commerce/commerce/index.md) functionalities. [Carts](../../../commerce/cart/cart/index.md), [order management](../../../commerce/order_management/order_management/index.md), and [shopping lists](../../../commerce/shopping_list/shopping_list/index.md) can't be used with products coming from Quable.
- [Catalogs](../../product_catalog_guide/index.md#catalogs) can't be created from Quable products.
- [Product assets](../../product_catalog_guide/index.md#product-assets) are not fully synchronized. Only the main product thumbnail from Quable is used.
- [Product-level access restrictions](../../../permissions/policies/index.md#products) based on product type are not supported.
- You can't define prices and availability for products with product codes exceeding 64 characters.
