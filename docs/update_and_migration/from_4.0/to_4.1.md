---
description: Update your installation to the latest v4.1 version from v4.0.
---

# Update from v4.0.x to v4.1

This update procedure applies if you are using v4.0.0.

Go through the following steps to update to v4.1.

!!! note

    During the update process you can encounter the following error:

    `Failed to create closure from callable: class 'Ibexa\Bundle\Commerce\Eshop\Twig\SilvercommonExtension' does not have a method 'getNavigation'`

    You can ignore this error, it does not require any action on your part.

## Update the app to latest version of v4.0

First, update your application to the latest version of v4.0: v4.0.8.

### Update Flex server

The `flex.ibexa.co` Flex server has been disabled.
If you are using earlier v4.x versions, and you have not done it before,
you have to update your Flex server.

To do it, in your `composer.json`, check whether the `https://flex.ibexa.co` endpoint is still listed in `extra.symfony.endpoint`.
If so, replace it with the new [`https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main`](https://github.com/ibexa/website-skeleton/blob/v4.1.5/composer.json#L96) endpoint.

You can do it manually, or by running the following command:

``` bash
composer config extra.symfony.endpoint "https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main"
```

Perform the update:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

Next, run:

``` bash
composer run post-install-cmd
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.0.3-to-4.0.4.sql
```

## Update the app to v4.1.0

When you have the v4.0 version, you can update to v4.1.0:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:4.1.0 --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:4.1.0 --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:4.1.0 --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files. Look through the old YAML files and move your custom configuration to the relevant new files.

Next, run:

``` bash
composer run post-install-cmd
```


### Update the database

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"
    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.0.0-to-4.1.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.0.0-to-4.1.0.sql
    ```

#### Ibexa Open Source

If you are using Ibexa OSS and have no access to Ibexa DXP's `ibexa/installer` package, database upgrade is not necessary.

## Update the app to latest version of v4.1

Now, update the application to the latest version of v4.1: [[= latest_tag_4_1 =]].

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_1 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_1 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_1 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

Next, run:

``` bash
composer run post-install-cmd
```

### Update the database

Apply the following database update scripts:

=== "MySQL"
    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.1.0-to-4.1.1.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.1.0-to-4.1.1.sql
    ```

## Configure the product catalog

!!! caution

    Always back up your data before you perform any actions on the product catalog.

Regardless of whether your application already uses the product catalog or you want 
to start using this functionality, you can choose to use the old features, 
present in v4.0.x, or upgrade to the all new product catalog that v4.1.x brings.

To use the legacy solution, in the `config/packages` folder, 
in YAML files with shop configuration, under the `parameters` key, 
make sure that the `ibexa.commerce.site_access.config.eshop.default.catalog_data_provider` parameter is set to `ez5`.
  
To use the new product catalog, since the new solution does not support the old 
price engine out of the box, in your price engine configuration, 
you must update the following parameters by providing the 
`Ibexa\\ProductCatalog\\Bridge\\PriceProvider` value in the `ibexa_setting` table, 
`commerce` group, `config` identifier:

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

You can do it by using the `UPDATE ibexa_setting` command.

??? note "Example of price engine configuration"

    ``` bash
    UPDATE ibexa_setting SET value = 
    '{"ibexa.commerce.site_access.config.basket.default.validHours": 120, 
    "ibexa.commerce.site_access.config.core.default.category_view": "product_list", 
    "ibexa.commerce.site_access.config.core.default.currency_list": {"CAD": "1.55686", "EUR": "1", "GBP": "0.86466", "USD": "1.23625"}, 
    "ibexa.commerce.site_access.config.basket.default.stock_in_column": true, 
    "ibexa.commerce.site_access.config.core.default.shipping_vat_code": "19", 
    "ibexa.commerce.site_access.config.basket.default.description_limit": 50, 
    "ibexa.commerce.site_access.config.core.default.bestseller_threshold": 1, 
    "ibexa.commerce.site_access.config.checkout.de.payment_method.invoice": true, 
    "ibexa.commerce.site_access.config.checkout.en.payment_method.invoice": true, 
    "ibexa.commerce.site_access.config.eshop.default.erp.variant_handling": "SKU_ONLY", 
    "ibexa.commerce.site_access.config.wishlist.default.description_limit": 50, 
    "ibexa.commerce.site_access.config.eshop.default.webconnector.password": "passwo", 
    "ibexa.commerce.site_access.config.eshop.default.webconnector.username": "admin", 
    "ibexa.commerce.site_access.config.checkout.de.shipping_method.standard": true, 
    "ibexa.commerce.site_access.config.checkout.en.shipping_method.standard": true, 
    "ibexa.commerce.site_access.config.core.default.marketing.olark_chat.id": "6295-386-10-7457", "ibexa.commerce.site_access.config.newsletter.default.newsletter_active": false, 
    "ibexa.commerce.site_access.config.basket.default.recalculatePricesAfter": "3 hours", 
    "ibexa.commerce.site_access.config.basket.stored.default.stock_in_column": true, 
    "ibexa.commerce.site_access.config.core.default.currency_rate_changed_at": "01.01.2018", 
    "ibexa.commerce.site_access.config.core.default.template_debitor_country": "DE", 
    "ibexa.commerce.site_access.config.eshop.default.webconnector.erpTimeout": 5, 
    "ibexa.commerce.site_access.config.eshop.default.webconnector.soapTimeout": 5, 
    "ibexa.commerce.site_access.config.basket.stored.default.description_limit": 50, 
    "ibexa.commerce.site_access.config.checkout.default.payment_method.invoice": true, 
    "ibexa.commerce.site_access.config.eshop.default.catalog_description_limit": 50, 
    "ibexa.commerce.site_access.config.newsletter.default.unsubscribe_globally": true, 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.basket":     ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.basket.default.refreshCatalogElementAfter": "1 hours", 
    "ibexa.commerce.site_access.config.checkout.default.shipping_method.standard": true, 
    "ibexa.commerce.site_access.config.core.default.enable_customer_number_login": false, 
    "ibexa.commerce.site_access.config.newsletter.default.newsletter2go_auth_key": "", 
    "ibexa.commerce.site_access.config.newsletter.default.newsletter2go_password": "", 
    "ibexa.commerce.site_access.config.newsletter.default.newsletter2go_username": "", 
    "ibexa.commerce.site_access.config.core.default.automatic_currency_conversion": true, 
    "ibexa.commerce.site_access.config.erp.default.web_connector.service_location": "http://webconnproxy.silver-eshop.de?config=harmony_wc3_noop_mapping", 
    "ibexa.commerce.site_access.config.core.default.marketing.olark_chat.activated": false, 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.wish_list": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.checkout.de.shipping_method.express_delivery": true, 
    "ibexa.commerce.site_access.config.checkout.en.shipping_method.express_delivery": true, 
    "ibexa.commerce.site_access.config.order.management.local.default.shipping_cost": "", 
    "ibexa.commerce.site_access.config.order.management.local.default.shipping_free": "", 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.comparison": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.core.default.bestseller_limit_on_catalog_page": 6, 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.quick_order": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.search_list": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.basket.default.additional_text_for_basket_line": false, 
    "ibexa.commerce.site_access.config.core.default.bestseller_limit_in_silver_module": 6, 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.product_list": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.stored_basket": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.core.de.standard_price_factory.fallback_currency": "EUR", 
    "ibexa.commerce.site_access.config.core.default.bestseller_limit_on_bestseller_page": 6, 
    "ibexa.commerce.site_access.config.core.default.use_template_debitor_contact_number": false, 
    "ibexa.commerce.site_access.config.core.en.standard_price_factory.fallback_currency": "EUR", 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.basket_variant": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.product_detail": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.checkout.default.shipping_method.express_delivery": false, 
    "ibexa.commerce.site_access.config.core.default.standard_price_factory.base_currency": "EUR", 
    "ibexa.commerce.site_access.config.core.default.use_template_debitor_customer_number": true, 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.bestseller_list": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.checkout.de.payment_method.paypal_express_checkout": true, 
    "ibexa.commerce.site_access.config.checkout.en.payment_method.paypal_express_checkout": true, 
    "ibexa.commerce.site_access.config.core.default.price_requests_without_customer_number": true, 
    "ibexa.commerce.site_access.config.eshop.default.last_viewed_products_in_session_limit": 10, 
    "ibexa.commerce.site_access.config.basket.default.discontinued_products_listener_active": true, 
    "ibexa.commerce.site_access.config.core.default.standard_price_factory.fallback_currency": "EUR", 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.slider_product_list": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.checkout.default.order_confirmation.sales_email_address": "", 
    "ibexa.commerce.site_access.config.checkout.default.payment_method.paypal_express_checkout": true, 
    "ibexa.commerce.site_access.config.basket.default.additional_text_for_basket_line_input_limit": 30, 
    "ibexa.commerce.site_access.config.price.default.price_service_chain.quick_order_line_preview": ["Ibexa\\\\ProductCatalog\\\\Bridge\\\\PriceProvider"], 
    "ibexa.commerce.site_access.config.newsletter.default.display_newsletter_box_for_logged_in_users": true, 
    "ibexa.commerce.site_access.config.basket.default.discontinued_products_listener_consider_packaging_unit": true}' WHERE `group` = 'commerce' AND identifier = 'config';
    ```

After you update the settings, you can proceed to working with your products.

## Finish update

Finish the update process:

``` bash
composer run post-install-cmd
```

Finally, generate the new GraphQL schema:

``` bash
php bin/console ibexa:graphql:generate-schema
```

YAML files with the schema are located in `config/graphql/types/ibexa`.
