# Configure storefront

Link to storefront

<yourdomain>/product-catalog




## Catalog configuration

With the `ibexa/storefront` package, you can configure the product catalog and make it available to your shop users. 

Before you start configuring the storefront, make sure you have configured [catalogs](https://doc.ibexa.co/projects/userguide/en/latest/pim/work_with_catalogs/#create-catalogs) in the Back office.

The configuration is avaible under the `ibexa.system.<scope>.storefront.catalog key.
It accepts the following values:

1\. All products available for all users:

```yaml
ibexa:
    system:
        site:
            storefront:
                catalog: ~
```
If the `null` as a key value is provided, the storefront exeposes the main product catalog (with all products) visibile for all users.

2\. To expose a single catalog with an identifier to all users only a catalog , provide a `string` value under the key:

```yaml
ibexa:
    system:
        site:
            storefront:
                catalog: custom_catalog
```

3\. Specific catalog for the defined customer group

First, create catalogs in the Back office.

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


## Retrieve catalog assign to user

`null` stands for the current user

The `\Ibexa\Contracts\Storefront\Repository\CatalogResolverInterface` service allows to retrieve product catalog available for a specific user.


### Configure user account

The `ibexa\user` settings mechanism can be reused in the `ibexa\storefront`.

Available settigns for a storefront user

