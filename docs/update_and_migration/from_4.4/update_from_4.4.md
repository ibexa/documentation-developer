---
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

### Define measurement base unit in configuration

If your installation has defined measurement units in the configuration,
you need to specify one of them as base unit in the `config/packages/ibexa_measurement.yaml` file:

```yaml
ibexa_measurement:
    types:
        my_type:
            my_unit: { symbol: my, is_base_unit: true }
```

Next, add unit conversion to `src/bundle/Resources/config/services/conversion.yaml`. 
For more information, see [Modify and add Measurement types and units](measurementfield.md#modify-and-add-measurement-types-and-units).

### Update the database

Next, update the database:

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.4.latest-to-4.5.0.sql

    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.4.latest-to-4.5.0.sql
    ```

#### Migrate richtext namespaces

If you earlier upgraded from v3.3 to v4.x and haven't run the migrate script yet, do it now, run:

```bash
php bin/console ibexa:migrate:richtext-namespaces
```

#### Ibexa Open Source

If you have no access to [[= product_name =]]'s `ibexa/installer` package, apply the following database update:

=== "MySQL"

    ``` sql
    CREATE TABLE ibexa_token_type
    (
        id int(11) NOT NULL AUTO_INCREMENT,
        identifier varchar(64) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY ibexa_token_type_unique (identifier)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
    
    CREATE TABLE ibexa_token
    (
        id int(11) NOT NULL AUTO_INCREMENT,
        type_id int(11) NOT NULL,
        token varchar(255) NOT NULL,
        identifier varchar(128) DEFAULT NULL,
        created int(11) NOT NULL DEFAULT 0,
        expires int(11) NOT NULL DEFAULT 0,
        PRIMARY KEY (id),
        UNIQUE KEY ibexa_token_unique (token,identifier,type_id),
        CONSTRAINT ibexa_token_type_id_fk
            FOREIGN KEY (type_id) REFERENCES ibexa_token_type (id)
                ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
    ```

=== "PostgreSQL"

    ``` sql
    CREATE TABLE ibexa_token_type
    (
        id serial PRIMARY KEY,
        identifier varchar(64) NOT NULL
    );
    
    CREATE TABLE ibexa_token
    (
        id serial PRIMARY KEY,
        type_id int NOT NULL
            CONSTRAINT ibexa_token_type_id_fk
                REFERENCES ibexa_token_type (id)
                ON DELETE CASCADE,
        token varchar(255) NOT NULL,
        identifier varchar(128) DEFAULT NULL,
        created int NOT NULL DEFAULT 0,
        expires int NOT NULL DEFAULT 0
    );
    ```

### Clean-up taxonomy database

If you didn't run it already when [migrating from 4.2 to 4.3](update_from_4.2.md#clean-up-taxonomy-database), run the following command for each of your taxonomies to ensure that there are no [Content items orphaned during deletion of subtrees](https://doc.ibexa.co/en/latest/content_management/taxonomy/taxonomy/#remove-orphaned-content-items) inherited from the earlier version's database:

`php bin/console ibexa:taxonomy:remove-orphaned-content <taxonomy> --force`

For example:

```bash
php bin/console ibexa:taxonomy:remove-orphaned-content tags --force
php bin/console ibexa:taxonomy:remove-orphaned-content product_categories --force
```

## Finish code update

Finish the code update by running:

```bash
composer run post-install-cmd
```

## Run data migration

If you are using Ibexa Experience or Ibexa Commerce,
you can now run data migration required by the Customer Portal and Commerce features to finish the update process:

- Customer Portal [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/customer_portal.yaml --name=2023_03_06_13_00_customer_portal.yaml
php bin/console ibexa:migrations:migrate --file=2023_03_06_13_00_customer_portal.yaml
```

- Corporate access role update [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/2023_05_09_12_40_corporate_access_role_update.yaml --name=2023_05_09_12_40_corporate_access_role_update.yaml
php bin/console ibexa:migrations:migrate --file=2023_05_09_12_40_corporate_access_role_update.yaml
```

- Corporate account [[% include 'snippets/commerce_badge.md' %]]

This migration allows all company members to shop in the frontend shop. If you have implemented business logic that depends on keeping company members out of the frontend shop, you can skip it:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/storefront/src/bundle/Resources/migrations/2023_04_27_10_30_corporate_account.yaml --name=2023_04_27_10_30_corporate_account.yaml
php bin/console ibexa:migrations:migrate --file=2023_04_27_10_30_corporate_account.yaml
```

- Storefront user update [[% include 'snippets/commerce_badge.md' %]]

```bash
php bin/console ibexa:migrations:import vendor/ibexa/storefront/src/bundle/Resources/migrations/2023_04_27_11_20_storefront_user_role_update.yaml --name=2023_04_27_11_20_storefront_user_role_update.yaml
php bin/console ibexa:migrations:migrate --file=2023_04_27_11_20_storefront_user_role_update.yaml
```

- Shipment permissions [[% include 'snippets/commerce_badge.md' %]]

```bash
php bin/console ibexa:migrations:import vendor/ibexa/shipping/src/bundle/Resources/install/migrations/shipment_permissions.yaml --name=shipment_permissions.yaml
php bin/console ibexa:migrations:migrate --file=shipment_permissions.yaml
```

- Order permissions [[% include 'snippets/commerce_badge.md' %]]

```bash
php bin/console ibexa:migrations:import vendor/ibexa/order-management/src/bundle/Resources/install/migrations/order_permissions.yaml --name=order_permissions.yaml
php bin/console ibexa:migrations:migrate --file=order_permissions.yaml
```

### v4.5.2

#### Database update

Run the following scripts:

=== "MySQL"

    ``` sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.1-to-4.5.2.sql
    ```

=== "PostgreSQL"

    ``` sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.1-to-4.5.2.sql
    ```
