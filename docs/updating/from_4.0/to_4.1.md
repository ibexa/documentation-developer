---
latest_tag: '4.1.1'
---

# Update from v4.0.x to v4.1

This update procedure applies if you are using v4.0.latest.

Go through the following steps to update to v4.1.

## Update the app to v4.1

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

Continue with updating the app:

=== "[[= product_name_content =]]"

    ``` bash
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files. Look through the old YAML files and move your custom configuration to the relevant new files.

## Update the database

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update script:

### Ibexa DXP

=== "MySQL"
    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.0.0-to-4.1.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.0.0-to-4.1.0.sql
    ```

## Configure the Product Catalog [[% include 'snippets/experience_badge.md' %]]

!!! caution

    Always back up your data before you perform any actions on your Product Catalog.

Regardless of whether your application already uses the Product Catalog or you want to start using this functionality, you can choose to use the old features, present in v4.0.x, or upgrade to the all new Product Catalog that v.4.1.x brings.

Either way, make sure that in `config/packages/ibexa_shop.yaml` you set a value of the 
`ibexa.commerce.site_access.config.eshop.default.catalog_data_provider` parameter correctly: 
to use the old Product Catalog bundle, leave the value as-is and continue to the next section.
To use the updated Product Catalog, change the value to `ibexa`, and perform the steps below.
  
The new Product Catalog does not support the old price engine, therefore in the `ibexa_setting` table, you must update the following parameters by providing the `Ibexa\\ProductCatalog\\Bridge\\PriceProvider` value:

```yaml
ibexa.commerce.site_access.config.price.default.price_service_chain.basket
ibexa.commerce.site_access.config.price.default.price_service_chain.wish_list
ibexa.commerce.site_access.config.price.default.price_service_chain.comparison
ibexa.commerce.site_access.config.price.default.price_service_chain.wish_list
ibexa.commerce.site_access.config.price.default.price_service_chain.comparison
ibexa.commerce.site_access.config.price.default.price_service_chain.quick_order
ibexa.commerce.site_access.config.price.default.price_service_chain.search_list
ibexa.commerce.site_access.config.price.default.price_service_chain.product_list
ibexa.commerce.site_access.config.price.default.price_service_chain.stored_basket
ibexa.commerce.site_access.config.price.default.price_service_chain.basket_variant
ibexa.commerce.site_access.config.price.default.price_service_chain.product_detail
ibexa.commerce.site_access.config.price.default.price_service_chain.bestseller_list
ibexa.commerce.site_access.config.price.default.price_service_chain.slider_product_list
ibexa.commerce.site_access.config.price.default.price_service_chain.quick_order_line_preview
```

After you update the settings, proceed to product remodeling.
For more information, see [Set up product for purchasing](<link_to_article>).

## Finish update

Finish the update process:

``` bash
composer run post-install-cmd
```

Finally, generate the new GraphQl schema:

``` bash
php bin/console ibexa:graphql:generate-schema
```
