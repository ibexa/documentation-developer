# Configure Storefront

Configure Storefront, including catalogs used, customer groups and user accounts.

Editions: Commerce

The Storefront is accessible under the `<yourdomain>/product-catalog`.

## Catalog configuration

With the `ibexa/storefront` package, you can configure the product catalog and make it available to your shop users.

Before you start configuring the Storefront, make sure you have created, configured, and published [catalogs](../../../../user/product_catalog/work_with_catalogs/index.md#create-catalogs) in the back office.

The configuration is available under the `ibexa.system.<scope>.storefront.catalog` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files). It accepts the following values:

1. All products available for all users:

```yaml
ibexa:
    system:
        site:
            storefront:
                catalog: ~
```

If `null`is provided as the value, the Storefront makes the main product catalog (with all products) visible for all users.

2. To expose a single catalog with an identifier to all users, provide a string value of the catalog identifier:

```yaml
ibexa:
    system:
        site:
            storefront:
                catalog: custom_catalog
```

3. Specific catalog for the defined customer group

You can expose different catalogs based on a customer group assigned to the current user.

To do it, provide the following configuration:

```yaml
ibexa:
    system:
        site:
            storefront:
                catalog:
                    default: standard
                    customer_group:
                        retailer: retailer_catalog
                        wholesale: wholesaler_catalog
```

The basic configuration of the Storefront can look as follows:

```yaml
ibexa:
    system:
        site_group:
            translation_siteaccesses:
                - site
                - site_pl
                - site_fr
                - site_de
            page_layout: '@ibexadesign/storefront/layout.html.twig'
            product_catalog:
                currencies:
                    - EUR
                    - PLN
                    - USD
                regions:
                    - poland
                    - france
                    - germany
                    - norway
            storefront:
                name: Ibexa
                logo: 'bundles/ibexaadminui/img/ibexa-logo.svg'
                catalog:
                    default: main
                    customer_group:
                        vip: vip
                product_list_limit: 9
                product_list_filters:
                    - product_type
                    - product_availability
                    - product_price
                product_render_action: 'Ibexa\Bundle\Storefront\Controller\ProductRenderController::renderAction'
                user_settings_groups:
                    - location
```

## Retrieve catalog assigned to user

The [`\Ibexa\Contracts\Storefront\Repository\CatalogResolverInterface`](../../../../../../ibexa/storefront/src/contracts/Repository/CatalogResolverInterface.php) interface allows retrieving the product catalog available for a specific user.

To retrieve catalog assigned for the current user, pass `null`.

### Configure user account

The following user settings mechanisms used in `ibexa/storefront` are reused from `ibexa/user` package:

- [change password feature](../../../users/passwords/index.md)
- user avatar

Settings for a Storefront user are configured under the `ibexa.system.<scope>.storefront.user_settings_groups` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        site_group:
            storefront:
                user_settings_groups:
                    - location
                    - custom_group
```

By default, only the `location` user settings is provided:

- Currency (from `ibexa/storefront`)
- Time zone
- Short date and time format
- Long date and time format
- Language
