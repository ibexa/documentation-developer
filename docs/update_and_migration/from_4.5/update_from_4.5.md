---
description: Update your installation to the latest v4.6 version from v4.5.x.
---

# Update from v4.5.x to v4.6

This update procedure applies if you are using a v4.5 installation.

## Update from v4.5.x to v4.5.latest

Before you update to v4.6, you need to go through the following steps to update to the latest maintenance release of v4.5 (v[[= latest_tag_4_5 =]]).

Note which version you actually have before starting.

### Update the application to v4.5.latest

Run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_5 =]] --with-all-dependencies --no-scripts
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_5 =]] --with-all-dependencies --no-scripts
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_5 =]] --with-all-dependencies --no-scripts
    ```

### Update the database

Depending on the version you started from, you may have several scripts to run:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.1-to-4.5.2.sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.2-to-4.5.3.sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.3-to-4.5.4.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.1-to-4.5.2.sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.2-to-4.5.3.sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.3-to-4.5.4.sql
    ```

## Update from v4.5.latest to v4.6

When you have the latest version of v4.5, you can update to v4.6.

### Update the application

First, run:

=== "[[= product_name_headless =]] (formerly [[= product_name_content =]])"

    ``` bash
    composer remove ibexa/content --no-update --no-scripts
    # Avoid recipes conflict between configuring ibexa/headless and unconfiguring ibexa/content
    rm symfony.lock
    composer require ibexa/headless:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/headless --force -v
    # Bump CKEditor dependencies
    yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    # Bump CKEditor dependencies
    yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    # Bump CKEditor dependencies
    yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
    ```

The `recipes:install` command installs new YAML configuration files.
Review the old YAML files and move your custom configuration to the relevant new files.

## Known issues

You may encounter one of the following errors during the process.

### Non-existent parameter

If you encounter a `You have requested a non-existent parameter` error
(like, for example, `You have requested a non-existent parameter "ibexa.dashboard.ibexa_news.limit".`),
this is due to a `config/bundles.php` built in a wrong order.
To fix this, use the order from https://github.com/ibexa/commerce-skeleton/blob/v4.6.0/config/bundles.php, and add any additional bundles again.

### Non-existent service

If you encouter the `You have requested a non-existent service "payum.storage.doctrine.orm".` error,
replace the config/packages/payum.yaml file with the contents from https://github.com/ibexa/recipes-dev/blob/master/ibexa/commerce/4.6/config/packages/payum.yaml.

## Finish code update

Finish the code update by running:

```bash
composer run post-install-cmd
```

### Update the database

Next, update the database:

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.latest-to-4.6.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.latest-to-4.6.0.sql
    ```

#### Update [[= product_name_com =]] database [[% include 'snippets/commerce_badge.md' %]]

For [[= product_name_com =]] installations, you also need to run the following command line:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.5.latest-to-4.6.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.5.latest-to-4.6.0.sql
    ```

And to play the following table creation request:

=== "MySQL"

    ``` sql
    CREATE TABLE ibexa_payment_token (
        hash VARCHAR(255) NOT NULL,
        afterUrl VARCHAR(255) DEFAULT NULL,
        targetUrl VARCHAR(255) NOT NULL,
        gatewayName VARCHAR(255) NOT NULL,
        details LONGTEXT DEFAULT NULL COMMENT '(DC2Type:object)',
        PRIMARY KEY(hash)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
    ```

=== "PostgreSQL"

    ``` sql
    CREATE TABLE ibexa_payment_token
    (
        hash VARCHAR(255) NOT NULL,
        afterurl VARCHAR(255) DEFAULT NULL,
        targeturl VARCHAR(255) NOT NULL,
        gatewayname VARCHAR(255) NOT NULL,
        details TEXT DEFAULT NULL,
        PRIMARY KEY(hash)
    ); 
    COMMENT ON COLUMN ibexa_payment_token.details IS '(DC2Type:object)';
    ```

## Run data migration

### Dashboard [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

If you are using [[= product_name_exp =]] or [[= product_name_com =]],
you must run data migration required by the dashboard and other features to finish the upgrade process:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/dashboard/src/bundle/Resources/migrations/structure.yaml --name=2023_09_23_14_15_dashboard_structure.yaml
php bin/console ibexa:migrations:import vendor/ibexa/dashboard/src/bundle/Resources/migrations/permissions.yaml --name=2023_10_10_16_14_dashboard_permissions.yaml
php bin/console ibexa:migrations:migrate --file=2023_09_23_14_15_dashboard_structure.yaml --file=2023_10_10_16_14_dashboard_permissions.yaml
```

## Revisit mandatory configuration

### Dashboard [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Define "Dashboards" location as contextual tree root:

```yaml
ibexa:
    system:
        # ...
        admin_group:
            content_tree_module:
                contextual_tree_root_location_ids:
                    #...
                    - 67 # Dashboards (clean installation)
```

### User profile

Ibexa DXP v4.6 introduced user profile for Backoffice users, allowing users to upload avatars, and provide personal information.

This feature is optional, and you can disable it by setting `enabled` flag to `false` in `ibexa.system.<scope>.user_profile` configuration:

```yaml
# /config/packages/ibexa_admin_ui.yaml
ibexa:
    system:
        # ...
        admin_group:
            user_profile:
                enabled: false
```

To enable the user profile, you must specify Content Type identifiers which represent the "editor" user, and field groups to be rendered in the user profile summary:

```yaml
# /config/packages/ibexa_admin_ui.yaml
ibexa:
    system:
        # ...
        admin_group:
            user_profile:
                enabled: true
                content_types: ['editor']
                field_groups: ['about', 'contact']
```

You can use your own Content Type that represents the Back Office user, or use the default one provided by [[= product_name =]]:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/installer/src/bundle/Resources/install/migrations/2023_12_07_20_23_editor_content_type.yaml --name=2023_12_07_20_23_editor_content_type.yaml
php bin/console ibexa:migrations:import vendor/ibexa/installer/src/bundle/Resources/install/migrations/2024_01_09_22_23_editor_permissions.yaml --name=2024_01_09_22_23_editor_permissions.yaml
php bin/console ibexa:migrations:migrate --file=2023_12_07_20_23_editor_content_type.yaml --file=2024_01_09_22_23_editor_permissions.yaml
```

### Site context

Site context is used in Content Tree to display only those Content items that belong to the selected website.

You can add locations that shoudn't be publicly accessible to the list of excluded paths:

```yaml
# /config/packages/ibexa_site_context.yaml
ibexa:
    system:
        # ...
        admin_group:
            site_context:
                excluded_paths:
                    - /1/5/     # Users
                    - /1/43/    # Media
                    - /1/55/    # Forms
                    - /1/56/    # Site skeletons
                    - /1/67/    # Dashboards
                    - /1/61/    # Product categorises
                    - /1/65/    # Corporate Account
                    - /1/57/    # Tags
```

## Revisit optional configuration

### Activity Log

By default, activity log keeps entries for 30 days. 
You can change this value by setting `ibexa.repositories.<name>.activity_log.truncate_after_days` parameter:

```yaml
ibexa:
    repositories:
        default:
            # ...
            activity_log:
                truncate_after_days: 10
```

## Revisit permissions

### Recent activity

You must add the "Activity Log / Read" policy (`activity_log/read`) to every role that has access to the Back Office, at least with the "Only own log" limitation.
This policy is mandatory to display the "Recent activity" block in [dashboards](#dashboard), and the "Recent activity" block in [user profiles](#user-profile). 

The following migration example allows users with the `Editor` role to access their own activity log:

```yaml
-   type: role
    mode: update
    match:
        field: identifier
        value: 'Editor'
    policies:
        mode: append
        list:
            - module: activity_log
              function: read
              limitations:
                  - identifier: activity_log_owner
                    values: []
```
