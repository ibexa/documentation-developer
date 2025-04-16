---
description: Install the Discounts LTS update.
month_change: false
---

# Install Discounts

Discounts are available as an LTS update to [[= product_name =]] Commerce, starting with version v4.6.18 or higher.
To use this feature you must first install the packages and configure them.

## Install packages

Run the following commands to install the packages:

``` bash
composer require ibexa/discounts
composer require ibexa/discount-codes
```

These commands add the feature code, service handlers, helper Twig templates, and configurations required for using Discounts.
It also modifies the permission system to account for the new functionality.

## Configure Discounts

Once the packages are installed, before you can start using Discounts, you must enable them by following these instructions.

### Modify the database schema

Run the following command, where `<database_name>` is the same name that you defined when you [installed [[= product_name =]]](../getting_started/install_ibexa_dxp.md#change-installation-parameters).

=== "MySQL"

    ```bash

    ```

=== "PostgreSQL"

    ```bash
    ```

This command modifies the existing database schema by adding database configuration required for using Discounts.

You can now restart you application and start [working with the Discounts feature]([[= user_doc =]]/discounts/work_with_discounts/).
