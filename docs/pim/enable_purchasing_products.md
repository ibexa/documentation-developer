---
description: Ensure your product catalog is ready for use with full configuration of products that enables purchasing them in the frontend shop.
---

# Enable purchasing products

To enable adding product to cart and purchasing from the catalog, the following configuration is required:

- at least [one region and one currency for the shop](#region-and-currency)
- [VAT rates per region](#vat-rates) and for each product type
- at least one [price](prices.md) for the product
- [availability](products.md#product-availability-and-stock) with positive or infinite stock for the product or product variant

!!! note "Configuring products in the UI"

    After you configure the region, currency and VAT rates for regions in settings, the store manager must set up the remaining parameters in the UI, such as, [VAT rates per product type]([[= user_doc =]]/pim/create_product_types/#vat), descriptions, attributes, assets, [prices]([[= user_doc =]]/pim/manage_prices/) and [availability]([[= user_doc =]]/pim/manage_availability_and_stock/) per product, and so on.

    For more information, see [User Documentation]([[= user_doc =]]/pim/products/#product-completeness).

## Region and currency

All currencies available in the system must be enabled in the Back Office under **Product Catalog** -> **Currencies**.

Additionally, you must configure currencies valid for specific SiteAccesses
under the `ibexa.system.<scope>.product_catalog.currencies` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        default:
            product_catalog:
                currencies:
                    - EUR
                    - GBP
                    - PLN
                regions:
                    - germany
                    - uk
                    - poland
```

In the `ibexa_storefront.yaml` file, under the `ibexa.system.<scope>.product_catalog.regions` configuration key, regions are set with `default` value. Remember to either exclude this element or extend it by [configuring other regions](enable_purchasing_products.md#configuring-other-regions-and-currencies).

```yaml
ibexa:
    system:
        storefront_group:
            product_catalog:
                currencies:
                    - EUR
                    - PLN
                regions:
                    - germany
                    - poland
        another_storefront_group:
            product_catalog:
                currencies:
                    - GBP
                regions:
                    - uk
```

This example uses the currencies and regions set in the [VAT rates' example below](#vat-rates).

### Configuring other regions and currencies

By default, the system always uses the first currency and the first region configured.

To implement a different logic, for example a switcher for preferred currencies and regions,
you need to subscribe to `Ibexa\Contracts\ProductCatalog\Events\CurrencyResolveEvent`
and `Ibexa\Contracts\ProductCatalog\Events\RegionResolveEvent` in your customization.

## VAT rates

You set up VAT percentage values corresponding to VAT rates in configuration:

``` yaml
ibexa:
    repositories:
        default:
            product_catalog:
                engine: default
                regions:
                    germany:
                        vat_categories:
                            standard: 19
                            reduced: 7
                            none: ~
                    uk:                                               
                        vat_categories:                            
                            standard: 20                            
                            reduced: 5                            
                            none: ~
                    poland:                                               
                        vat_categories:                            
                            standard: 23                            
                            reduced: 8                            
                            none: ~
```

You can then assign VAT rates that apply to every product type in each of the supported regions.
To do it, in the Back Office, [open the product type for editing]([[= user_doc =]]/pim/create_product_types/#vat), and navigate to the **VAT rates** area.

![Assigning VAT rates to a product type](catalog_vat_rates.png "Assigning VAT rates to a product type")
