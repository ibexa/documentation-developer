--
description: Update your installation to the latest v4.5 version from v4.4.x.
---

# Update from v4.4.x to v4.5

This update procedure applies if you are using a v4.4 installation.

## Update from v4.4.x to v4.4.latest

Before you update to v4.5, you need to go through the following steps to update to the latest maintenance release of v4.4 (v[[= latest_tag_4_4 =]]).

### Update the application to v4.4.latest

Run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    ```

## Update from v4.4.latest to v4.5

When you have the latest version of v4.4, you can update to v4.5.

### Update the application

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_5 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_5 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_5 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files.
Review the old YAML files and move your custom configuration to the relevant new files.

### Update the database

Next, update the database if you are using Ibexa Commerce.
Ibexa Content and Ibexa Experience do not require the database update.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.4.latest-to-4.5.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.4.latest-to-4.5.0.sql
    ```

#### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, database upgrade is not necessary.


## Finish code update

Finish the code update by running:

```bash
composer run post-install-cmd
```

## Run data migration

### Customer Portal

If you are using Ibexa Experience or Ibexa Commerce,
you can now run data migration required by the Customer Portal and Commerce features to finish the update process:

- Customer Portal:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/customer_portal.yaml --name=2023_03_06_13_00_customer_portal.yaml
php bin/console ibexa:migration:migrate --file=2023_03_06_13_00_customer_portal.yaml
```

- Corporate account — this migration allows all company members to shop in the frontend shop. If you have implemented business logic that depends on keeping company members out of the frontend shop, you can skip it:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/storefront/src/bundle/Resources/migrations/2023_04_27_10_30_corporate_account.yaml --name=2023_04_27_10_30_corporate_account.yaml
php bin/console ibexa:migration:migrate --file=2023_04_27_10_30_corporate_account.yaml
```

- Storefront user update:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/storefront/src/bundle/Resources/migrations/2023_04_27_11_20_storefront_user_role_update.yaml --name=2023_04_27_11_20_storefront_user_role_update.yaml
php bin/console ibexa:migration:migrate --file=2023_04_27_11_20_storefront_user_role_update.yaml
```