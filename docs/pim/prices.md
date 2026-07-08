---
description: The price engine calculates product prices taking into account customer groups, currencies and taxes.
---

# Prices

The price engine is responsible for calculating prices for products in the [catalog](pim.md).

## Custom pricing

You can set up basic price rules depending on [customer groups](customer_groups.md), or use the [Discounts LTS Update](discounts.md) for more control over the price reduction.

Use the first option for basic use cases, for example to globally manage custom prices for your resellers.
Each customer group can have a default price discount that applies to all products.

With the Discounts feature, you can create time-limited offers that apply only to specified regions, currencies, products, customers, and more.

### Assign prices dynamically

You could create a customer group resolver that provides custom price logic, for example, by retrieving user address from the customer profile, and assigning a customer group to the customer based on the address.

Such resolver must implement the [`Ibexa\Contracts\ProductCatalog\CustomerGroupResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-CustomerGroupResolverInterface.html) interface.

You must then register it as a service with the `ibexa.product_catalog.customer_group.resolver` tag.

## Currency

[[= product_name =]] ships with a list of available currencies, and you can also add custom currencies.
To use currencies in your shop, you need to first enable them in the back office.

## VAT

You can [configure VAT rate globally](pim_configuration.md#vat-rates) (per SiteAccess), or set it individually for each product type and product.
