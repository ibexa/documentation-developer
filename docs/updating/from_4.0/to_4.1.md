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

Review the `bundles.php` and leave only third-party entires and entries added by the `recipes:install` command, that start with `Ibexa\Bundle`.

## Update the database

Apply the following database update script:

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

## Update your custom code

### Product catalog

After you update the application and database, account for changes related to the refactored Product Catalog.
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
