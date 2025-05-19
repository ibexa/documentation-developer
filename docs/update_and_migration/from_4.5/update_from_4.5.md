---
description: Update your installation to the latest v4.6 version from v4.5.x.
---

# Update from v4.5.x to v4.6

This update procedure applies if you're using a v4.5 installation.

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

### v4.5.2

#### Database update

Run the following scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.1-to-4.5.2.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.1-to-4.5.2.sql
    ```

### v4.5.3

#### Database update [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Run the following scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.2-to-4.5.3.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.2-to-4.5.3.sql
    ```

### v4.5.4

#### Database update

Run the following scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.3-to-4.5.4.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.3-to-4.5.4.sql
    ```

### v4.5.5

No additional steps needed.

### v4.5.6

#### Database update

Run the following scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.5-to-4.5.6.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.5-to-4.5.6.sql
    ```

### v4.5.7

No additional steps needed.

## Update from v4.5.latest to v4.6

When you have the latest version of v4.5, you can update to v4.6.
Check [the requirements](../../getting_started/requirements.md) first.
This version adds support for PHP 8.2 and 8.3, but requires using at least Node 18.

### Update the application

First, run:

=== "[[= product_name_headless =]] (formerly [[= product_name_content =]])"

    ``` bash
    composer remove ibexa/content --no-update --no-scripts
    # Avoid recipes conflict between configuring ibexa/headless and unconfiguring ibexa/content
    rm symfony.lock
    composer require ibexa/headless:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/headless --force -v
    # Update CKEditor dependencies
    yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    # Update CKEditor dependencies
    yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_6 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    # Update CKEditor dependencies
    yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
    ```

The `recipes:install` command installs new YAML configuration files.
Review the old YAML files and move your custom configuration to the relevant new files.

If you're using [custom CKEditor plugins](extend_online_editor.md#add-ckeditor-plugins), update them as well to use the same version range for all CKEditor dependencies.

## Remove `node_modules` and `yarn.lock`

Next, remove `node_modules` and `yarn.lock` before running `composer run post-update-cmd`,
otherwise you can encounter errors during compiling.

``` bash
rm -Rf node_modules
rm yarn.lock
```

## Finish code update

Finish the code update by running:

```bash
composer run post-install-cmd
```

### Known issues

You may encounter one of the following errors during the process.

#### Non-existent parameter

If you encounter a `You have requested a non-existent parameter` error
(like, for example, `You have requested a non-existent parameter "ibexa.dashboard.ibexa_news.limit".`),
this is due to incorrect order of entries in `config/bundles.php`.
To fix this, use the order from the skeleton you're using, and add any extra bundles again.

=== "[[= product_name_headless =]]"
    Use [https://github.com/ibexa/headless-skeleton/blob/v[[= latest_tag_4_6 =]]/config/bundles.php](https://github.com/ibexa/headless-skeleton/blob/v[[= latest_tag_4_6 =]]/config/bundles.php) as a reference.

=== "[[= product_name_exp =]]"
    Use [https://github.com/ibexa/experience-skeleton/blob/v[[= latest_tag_4_6 =]]/config/bundles.php](https://github.com/ibexa/experience-skeleton/blob/v[[= latest_tag_4_6 =]]/config/bundles.php) as a reference.

=== "[[= product_name_com =]]"
    Use [https://github.com/ibexa/commerce-skeleton/blob/v[[= latest_tag_4_6 =]]/config/bundles.php](https://github.com/ibexa/commerce-skeleton/blob/v[[= latest_tag_4_6 =]]/config/bundles.php) as a reference.


#### Non-existent service

If you encounter the `You have requested a non-existent service "payum.storage.doctrine.orm".` error,
replace the config/packages/payum.yaml file with the contents from https://github.com/ibexa/recipes-dev/blob/master/ibexa/commerce/4.6/config/packages/payum.yaml.

## Update the database

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

### Update [[= product_name_com =]] database [[% include 'snippets/commerce_badge.md' %]]

For [[= product_name_com =]] installations, you also need to run the following command line:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.5.latest-to-4.6.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.5.latest-to-4.6.0.sql
    ```

And apply the following database script:

=== "MySQL"

    ``` sql
    CREATE TABLE ibexa_payment_token (
        hash VARCHAR(255) NOT NULL,
        afterUrl VARCHAR(255) DEFAULT NULL,
        targetUrl VARCHAR(255) NOT NULL,
        gatewayName VARCHAR(255) NOT NULL,
        details LONGTEXT DEFAULT NULL COMMENT '(DC2Type:object)',
        PRIMARY KEY(hash)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
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

### Image picker migration

The new Image picker by default expects an `ezkeyword` field type to exist in the `image` content type.

You can add it running the following commands:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/image-picker/src/bundle/Resources/migrations/2023_12_06_15_00_image_content_type.yaml --name=2023_12_06_15_00_image_content_type.yaml
php bin/console ibexa:migrations:migrate --file=2023_12_06_15_00_image_content_type.yaml
```

### Dashboard migration [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

If you're using [[= product_name_exp =]] or [[= product_name_com =]],
you must run data migration required by the dashboard and other features to finish the upgrade process:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/dashboard/src/bundle/Resources/migrations/structure.yaml --name=2023_09_23_14_15_dashboard_structure.yaml
php bin/console ibexa:migrations:import vendor/ibexa/dashboard/src/bundle/Resources/migrations/permissions.yaml --name=2023_10_10_16_14_dashboard_permissions.yaml
php bin/console ibexa:migrations:import vendor/ibexa/activity-log/src/bundle/Resources/migrations/dashboard_structure.yaml --name=2023_12_04_13_34_activity_log_dashboard_structure.yaml
php bin/console ibexa:migrations:import vendor/ibexa/personalization/src/bundle/Resources/migrations/dashboard_structure.yaml --name=2023_12_05_17_00_personalization_dashboard_structure.yaml
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/dashboard_structure.yaml --name=2023_11_20_21_32_product_catalog_dashboard_structure.yaml
php bin/console ibexa:migrations:migrate --file=2023_09_23_14_15_dashboard_structure.yaml --file=2023_10_10_16_14_dashboard_permissions.yaml --file=2023_12_04_13_34_activity_log_dashboard_structure.yaml --file=2023_12_05_17_00_personalization_dashboard_structure.yaml --file=2023_11_20_21_32_product_catalog_dashboard_structure.yaml
```

!!! caution

    The `2023_10_10_16_14_dashboard_permissions.yaml` migration creates a role dedicated for dashboard management and assigns it to the Editors user group.
    If you have custom user groups which need to manipulate dashboards, you need to skip this migration, copy it to your migrations folder (by default, `src/Migrations/Ibexa/migrations`) and adjust it according to your needs before execution.

For [[= product_name_com =]] there's an additional migration:
``` bash
php bin/console ibexa:migrations:import vendor/ibexa/order-management/src/bundle/Resources/install/migrations/dashboard_structure.yaml --name=2023_11_20_14_33_order_dashboard_structure.yaml
php bin/console ibexa:migrations:migrate --file=2023_11_20_14_33_order_dashboard_structure.yaml
```

### Ibexa Open Source

If you don't have access to [[= product_name =]]'s `ibexa/installer` package and cannot apply the scripts from `vendor/ibexa/installer` directory, apply the following database update instead:

=== "MySQL"

    ``` sql
    ALTER TABLE `ibexa_token`
    ADD COLUMN `revoked` BOOLEAN NOT NULL DEFAULT false;
    ```

=== "PostgreSQL"

    ``` sql
    ALTER TABLE "ibexa_token"
    ADD "revoked" BOOLEAN DEFAULT false NOT NULL;
    ```

## Revisit configuration

### Revisit mandatory configuration

#### Dashboard configuration [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

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

#### User profile

[[= product_name =]] v4.6 introduced user profile for Backoffice users, allowing users to upload avatars, and provide personal information.

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

To enable the user profile, you must specify content type identifiers which represent the "editor" user, and field groups to be rendered in the user profile summary:

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

You can use your own content type that represents the back office user, or use the default one provided by [[= product_name =]]:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/installer/src/bundle/Resources/install/migrations/2023_12_07_20_23_editor_content_type.yaml --name=2023_12_07_20_23_editor_content_type.yaml
php bin/console ibexa:migrations:import vendor/ibexa/installer/src/bundle/Resources/install/migrations/2024_01_09_22_23_editor_permissions.yaml --name=2024_01_09_22_23_editor_permissions.yaml
php bin/console ibexa:migrations:migrate --file=2023_12_07_20_23_editor_content_type.yaml --file=2024_01_09_22_23_editor_permissions.yaml
```

#### Site context

Site context is used in content tree to display only those content items that belong to the selected website.

You can add locations that shouldn't be publicly accessible to the list of excluded paths:

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

### Revisit optional configuration

#### Activity log [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

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

### Revisit permissions

#### Recent activity [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

You must add the `Activity Log / Read` policy (`activity_log/read`) to every role that has access to the back office, at least with the "Only own log" limitation.
This policy is mandatory to display the "Recent activity" block in [dashboards](#dashboard-migration), and the "Recent activity" block in [user profiles](#user-profile).

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

## Update Solr configuration

Solr configuration changes with the addition of spellchecking feature.

Configure the `spellcheck` component in `solrconfig.xml`:

```xml
  <searchComponent name="spellcheck" class="solr.SpellCheckComponent">
    <lst name="spellchecker">
      <str name="name">default</str>
      <str name="field">meta_content__text_t</str>
      <str name="classname">solr.DirectSolrSpellChecker</str>
      <str name="distanceMeasure">internal</str>
      <float name="accuracy">0.5</float>
      <int name="maxEdits">2</int>
      <int name="minPrefix">1</int>
      <int name="maxInspections">5</int>
      <int name="minQueryLength">4</int>
      <float name="maxQueryFrequency">0.01</float>
    </lst>
  </searchComponent>
```

Add this `spellcheck` component to the `/select` request handler: 

```xml
  <requestHandler name="/select" class="solr.SearchHandler">
    <arr name="last-components">
      <str>spellcheck</str>
    </arr>
    <!-- […] -->
  </requestHandler>
```

!!! note

    You can [generate new Solr configuration files using `generate-solr-config.sh`](install_solr.md#generate-solr-configuration-automatically),
    and merge `spellcheck` configuration by comparing new files with your existing setup.

Restart Solr for `solrconfig.xml` changes to take effect.

## Update Elasticsearch schema

Elasticsearch schema's templates change, for example, with the addition of new features such as spellchecking.
When this happens, you need to erase the index, update the schema, and rebuild the index.

To delete the index, you can use an HTTP request.
Use the command as in the following example:

```bash
curl --request DELETE 'https://elasticsearch:9200/_all'
```

To update the schema, and then reindex the content, use the following commands:

```bash
php bin/console ibexa:elasticsearch:put-index-template --overwrite
php bin/console ibexa:reindex
```

## Update to v4.6.latest

Now, proceed to the last step, [updating to the latest v4.6 patch version](update_from_4.6.md).
