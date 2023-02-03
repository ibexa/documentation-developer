---
description: The price engine calculates product prices taking into account customer groups, currencies and taxes.
---

# Prices

The price engine is responsible for calculating prices for products in the [catalog](pim.md).

## Custom pricing

You can set up different prices depending on [customer groups](customer_groups.md).

Each customer group can have a default price discount that applies to all products.

You can also set different prices for specific products or product variants for different customer groups.

### Assign prices dynamically

You could create a customer group resolver that provides custom price logic, 
for example, by retrieving user address from the customer profile, and assigning 
a customer group to the customer based on the address. 

Such resolver must implement the `Ibexa\Contracts\ProductCatalog\CustomerGroupResolverInterface` 
interface. 

You must then register it as a service with the `ibexa.product_catalog.customer_group.resolver` tag.

## Currency

[[= product_name =]] ships with a list of available currencies, and you can also add custom currencies.
To use currencies in your shop, you need to first enable them in the Back Office.

## VAT

You can [configure VAT rate globally](pim_configuration.md#vat-rates) (per SiteAccess),
or set it individually for each product type and product.
