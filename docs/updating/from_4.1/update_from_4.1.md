---
description: Update your installation to the v4.1.latest version from an earlier v4.1.x version.
latest_tag_4_1: '4.1.5'
latest_tag_4_2: '4.2.0'
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

The `recipes:install` command installs new YAML configuration files. Look through the old YAML files and move your custom configuration to the relevant new files.

### Update the database

Next, update the database.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.1.latest-to-4.2.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.1.latest-to-4.2.0.sql
    ```
