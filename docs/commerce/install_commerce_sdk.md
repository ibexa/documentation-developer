---
description: Install the Commerce SDK on top of Cohesivo to add e-commerce capabilities to your project.
edition: commerce
month_change: false
---

# Install [[= product_name_commerce_sdk =]]

[[= product_name_commerce_sdk =]] adds e-commerce capabilities, such as cart, checkout, payments, shipping, order management, discounts, and shopping lists, to [[= product_name =]].
For more information, see [[[= product_name_commerce_sdk =]] product guide](../ibexa_products/commerce_sdk.md).

Before you can install [[= product_name_commerce_sdk =]], you must [install and configure [[= product_name =]]](../getting_started/install_cohesivo.md).

## Install package

Run the following command to add [[= product_name_commerce_sdk =]] to your project:

``` bash
composer require ibexa/cohesivo-commerce-sdk
```

The associated Symfony Flex recipes configure the bundles and their routes.

## Modify database schema

[[= product_name_base =]] Doctrine migrations manage the database schema for the [[= product_name_commerce_sdk =]] packages.

- To see a list of known migrations, and find out which ones are pending for the whole project, run:

    ```bash
    php bin/console ibexa:doctrine:migrations:versions
    ```

- To preview the changes before you apply them, use `--dry-run` with `--write-sql`:

    ```bash
    php bin/console ibexa:doctrine:migrations:migrate --dry-run --write-sql=var/migration-preview.sql
    ```

[[% include 'snippets/update/db/doctrine_migration_preview_caution.md' %]]

- To apply pending migrations:

    ```bash
    php bin/console ibexa:doctrine:migrations:migrate
    ```

    This command applies all pending migrations for the project.

[[% include 'snippets/update/db/doctrine_migration_one_by_one.md' %]]

## Configure features

Some [[= product_name_commerce_sdk =]] features require additional configuration, for example:

- [Configure checkout](configure_checkout.md)
- [Configure payment](configure_payment.md)
- [Configure shipping](configure_shipment.md)
- [Configure storefront](configure_storefront.md)
- [Configure order management](configure_order_management.md)
- [Configure discounts](configure_discounts.md)
- [Configure shopping list](configure_shopping_list.md)

## Add transactional emails

You can further extend [[= product_name_commerce_sdk =]] with transactional emails, by installing the Actito connector [add-on](cohesivo_products.md#add-ons).
For more information, see [Transactional emails](transactional_emails.md).
