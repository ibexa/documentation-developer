---
description: Install the Discounts LTS update.
month_change: true
editions:
    - lts-update
    - commerce
---

# Install Discounts

Discounts are available as an LTS update to [[= product_name_com =]], starting with version v4.6.19 or higher.
To use this feature you must first install the packages and configure them.

## Install packages

Run the following commands to install the packages:

``` bash
composer require ibexa/discounts ibexa/discount-codes
```

These commands add the feature code, service handlers, helper Twig templates, and configurations required for using Discounts.
It also modifies the permission system to account for the new functionality.

## Configure Discounts

Once the packages are installed, before you can start using Discounts, you must enable them by following these instructions.

### Modify the database schema

Run the following command, where `<database_name>` is the same name that you defined when you [installed [[= product_name =]]](../getting_started/install_ibexa_dxp.md#change-installation-parameters).

=== "MySQL"
    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.6.latest-discounts-lts-update.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.6.latest-discounts-lts-update.sql
    ```

This command modifies the existing database schema by adding database configuration required for using Discounts.

### Configuration (optional)

Use the built-in SiteAccess-aware parameters to change the default discount configuration.

The following settings are available:

- `list_per_page_limit` controls the number of discounts displayed on a single page in discount list view
- `products_list_per_page_limit` controls the number of products displayed on a single page in a discount details view

You can set them as in the following example:

``` yaml
ibexa:
    system:
        admin_group:
            discounts:
                pagination:
                    list_per_page_limit: 10
                    products_list_per_page_limit: 15
```

You can now restart you application and start working with the Discounts feature.
