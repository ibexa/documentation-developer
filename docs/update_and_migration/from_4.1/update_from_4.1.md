---
description: Update your installation to the v4.2.latest version from an v4.1 version.
---

# Update from v4.1.x to v4.2

This update procedure applies if you are using a v4.1 installation.

## Update from v4.1.x to v4.1.latest

Before you update to v4.2, you need to go through the following steps to update to the latest maintenance release of v4.1 (v[[= latest_tag_4_1 =]]).

### Update the application

Run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_1 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_1 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_1 =]] --with-all-dependencies --no-scripts
    ```

## Update from v4.1.latest to v4.2

When you have the latest version of v4.1, you can update to v4.2.

### Update the application

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_2 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_2 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_2 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files. 
Review the old YAML files and move your custom configuration to the relevant new files.

#### Run data migration

Next, run data migration required by Product Categories:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/2022_06_23_09_39_product_categories.yaml --name=013_product_categories.yaml
```

If you are using [[= product_name_exp =]] or [[= product_name_com =]], run data migration required by the Customer portal feature:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/corporate_account.yaml --name=001_corporate_account.yaml
```

If you are using [[= product_name_com =]], additionally run:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/corporate_account_commerce.yaml --name=002_corporate_account_commerce.yaml
```

Run `php bin/console ibexa:migrations:migrate -v --dry-run` to ensure that all migrations are ready to be performed.
If the dry run is successful, run:

``` bash
php bin/console ibexa:migrations:migrate
```

### Update the database

Next, update the database.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.1.latest-to-4.2.0.sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.2.2-to-4.2.3.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.1.latest-to-4.2.0.sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.2.2-to-4.2.3.sql
    ```

#### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, database upgrade is not necessary.

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips),
unless you can verify based on your log files that the vulnerability has not been exploited,
you should [revoke passwords](https://doc.ibexa.co/en/latest/users/user_management/#revoking-passwords) for all affected users.

### Remove `node_modules` and `yarn.lock`

Next, remove `node_modules` and `yarn.lock` before running `composer run post-update-cmd`,
otherwise you can encounter errors during compiling.

``` bash
rm -Rf node_modules
rm -Rf yarn.lock
```
