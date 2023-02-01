---
description: Configure Storefront
edition: commerce
---
# Configure Storefront

The Storefront is accesible under the `<yourdomain>/product-catalog`.

## Catalog configuration

With the `ibexa/storefront` package, you can configure the product catalog and make it available to your shop users. 

Before you start configuring the Storefront, make sure you have cerated and configured [catalogs](https://doc.ibexa.co/projects/userguide/en/latest/pim/work_with_catalogs/#create-catalogs) in the Back Office.

The configuration is avaible under the `ibexa.system.<scope>.storefront.catalog` key.
It accepts the following values:

1\. All products available for all users:

```yaml
ibexa:
    system:
        site:
            storefront:
                catalog: ~
```
If the `null` as a key value is provided, the Storefront makes the main product catalog (with all products) visibile for all users.

2\. To expose a single catalog with an identifier to all users only a catalog, provide a `string` value under the key:

```yaml
ibexa:
    system:
        site:
            storefront:
                catalog: custom_catalog
```

3\. Specific catalog for the defined customer group

First, create catalogs in the Back Office.

You can expose different catalogs based on a customer group assigned to the current user.

Next, provide the following configuration:

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

The basic configuration of the Storefront can look as the following:

``` yaml
[[= include_file('code_samples/front/shop/storefront/config/packages/ibexa.yaml') =]]
```

## Retrieve catalog assigned to user

`null` stands for the current user

The `\Ibexa\Contracts\Storefront\Repository\CatalogResolverInterface` service allows to retrieve product catalog available for a specific user.

```php

namespace Ibexa\Contracts\Storefront\Repository;

use Ibexa\Contracts\Core\Repository\Values\User\User;
use Ibexa\Contracts\ProductCatalog\Values\CatalogInterface;

interface CatalogResolverInterface
{
    public function resolveCatalog(?User $user = null): ?CatalogInterface;
}
```

### Configure user account

The following user settings mechanisms used in `ibexa/storefront` are reused from `ibexa/user` package:

- [change password feature](../../users/user_management.md)
- user avatar

Settings for a Storefront user are configured under the `ibexa.system.<scope>.storefront.user_settings_groups:

```yaml
ibexa:
    system:
        site_group:
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

