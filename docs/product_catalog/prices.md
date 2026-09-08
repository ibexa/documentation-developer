---
description: The price engine calculates product prices taking into account customer groups, currencies and taxes.
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    States that a VAT rate can be set globally, meaning per SiteAccess. Confirm the
    per-SiteAccess scope of VAT rates once SiteAccess configuration moves to a UI.

    Links to the deleted discounts.md page and the generated PHP API reference were
    removed; check that the surrounding text still reads correctly.
---

# Prices

The price engine is responsible for calculating prices for products in the [product catalog](product_catalog.md).

## Custom pricing

You can set up basic price rules depending on [customer groups](customer_groups.md).

Use this option to globally manage custom prices, for example for your resellers.
Each customer group can have a default price discount that applies to all products.

### Assign prices dynamically

You could create a customer group resolver that provides custom price logic, for example, by retrieving user address from the customer profile, and assigning a customer group to the customer based on the address.

Such resolver must implement the `Ibexa\Contracts\ProductCatalog\CustomerGroupResolverInterface` interface.

You must then register it as a service with the `ibexa.product_catalog.customer_group.resolver` tag.

## Currency

[[= product_name =]] ships with a list of available currencies, and you can also add custom currencies.
To use currencies in your shop, you need to first enable them in the back office.

## VAT

You can [configure VAT rate globally](product_catalog_configuration.md#vat-rates) (per SiteAccess), or set it individually for each product type and product.
