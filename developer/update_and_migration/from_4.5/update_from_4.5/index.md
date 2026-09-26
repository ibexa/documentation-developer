# Update from v4.5.x to v4.6

Update your installation to the latest v4.6 version from v4.5.x.

This update procedure applies if you're using a v4.5 installation.

## Update from v4.5.x to v4.5.latest

Before you update to v4.6, you need to go through the following steps to update to the latest maintenance release of v4.5 (v4.5.7).

Note which version you actually have before starting.

### Update the application to v4.5.latest

Run:

**Ibexa Content**

```bash
composer require ibexa/content:4.5.7 --with-all-dependencies --no-scripts
```

**Ibexa Experience**

```bash
composer require ibexa/experience:4.5.7 --with-all-dependencies --no-scripts
```

**Ibexa Commerce**

```bash
composer require ibexa/commerce:4.5.7 --with-all-dependencies --no-scripts
```

### v4.5.2

#### Database update

Run the following scripts:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.1-to-4.5.2.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.1-to-4.5.2.sql
```

### v4.5.3

#### Database update (Experience, Commerce)

Run the following scripts:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.2-to-4.5.3.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.2-to-4.5.3.sql
```

### v4.5.4

#### Database update

Run the following scripts:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.3-to-4.5.4.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.3-to-4.5.4.sql
```

### v4.5.5

No additional steps needed.

### v4.5.6

#### Database update

Run the following scripts:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.5-to-4.5.6.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.5-to-4.5.6.sql
```

### v4.5.7

No additional steps needed.

## Update from v4.5.latest to v4.6

When you have the latest version of v4.5, you can update to v4.6. Check [the requirements](../../../getting_started/requirements/index.md) first. This version adds support for PHP 8.2 and 8.3, but requires using at least Node 18.

### Update the application

First, run:

**Ibexa Headless (formerly Ibexa Content)**

```bash
composer remove ibexa/content --no-update --no-scripts
# Avoid recipes conflict between configuring ibexa/headless and unconfiguring ibexa/content
rm symfony.lock
composer require ibexa/headless:4.6.32 --with-all-dependencies --no-scripts
composer recipes:install ibexa/headless --force -v
# Update CKEditor dependencies
yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
```

**Ibexa Experience**

```bash
composer require ibexa/experience:4.6.32 --with-all-dependencies --no-scripts
composer recipes:install ibexa/experience --force -v
# Update CKEditor dependencies
yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
```

**Ibexa Commerce**

```bash
composer require ibexa/commerce:4.6.32 --with-all-dependencies --no-scripts
composer recipes:install ibexa/commerce --force -v
# Update CKEditor dependencies
yarn add @ckeditor/ckeditor5-alignment@^40.1.0 @ckeditor/ckeditor5-build-inline@^40.1.0 @ckeditor/ckeditor5-dev-utils@^39.0.0 @ckeditor/ckeditor5-widget@^40.1.0 @ckeditor/ckeditor5-theme-lark@^40.1.0 @ckeditor/ckeditor5-code-block@^40.1.0
```

The `recipes:install` command installs new YAML configuration files. Review the old YAML files and move your custom configuration to the relevant new files.

If you're using [custom CKEditor plugins](../../../content_management/rich_text/extend_online_editor/index.md#add-ckeditor-plugins), update them as well to use the same version range for all CKEditor dependencies.

## Remove `node_modules` and `yarn.lock`

Next, remove `node_modules` and `yarn.lock` before running `composer run post-update-cmd`, otherwise you can encounter errors during compiling.

```bash
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

If you encounter a `You have requested a non-existent parameter` error (like, for example, `You have requested a non-existent parameter "ibexa.dashboard.ibexa_news.limit".`), this is due to incorrect order of entries in `config/bundles.php`. To fix this, use the order from the skeleton you're using, and add any extra bundles again.

**Ibexa Headless**

Use <https://github.com/ibexa/headless-skeleton/blob/v4.6.32/config/bundles.php> as a reference.

**Ibexa Experience**

Use <https://github.com/ibexa/experience-skeleton/blob/v4.6.32/config/bundles.php> as a reference.

**Ibexa Commerce**

Use <https://github.com/ibexa/commerce-skeleton/blob/v4.6.32/config/bundles.php> as a reference.

#### Non-existent service

If you encounter the `You have requested a non-existent service "payum.storage.doctrine.orm".` error, replace the config/packages/payum.yaml file with the contents from <https://github.com/ibexa/recipes-dev/blob/master/ibexa/commerce/4.6/config/packages/payum.yaml>.

## Update the database

Next, update the database:

> **Caution: Caution**
>
> Always back up your data before running any database update scripts.
>
> After updating the database, clear the cache.
>
> Don't use `--force` argument for `mysql` / `psql` commands when performing update queries. If there is any problem during the update, it's best if the query fails immediately, so you can fix the underlying problem before you execute the update again. If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.

Apply the following database update scripts:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.latest-to-4.6.0.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.latest-to-4.6.0.sql
```

### Update Ibexa Commerce database (Commerce)

For Ibexa Commerce installations, you also need to run the following command line:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/commerce/ibexa-4.5.latest-to-4.6.0.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/commerce/ibexa-4.5.latest-to-4.6.0.sql
```

And apply the following database script:

**MySQL**

```sql
CREATE TABLE ibexa_payment_token (
    hash VARCHAR(255) NOT NULL,
    afterUrl VARCHAR(255) DEFAULT NULL,
    targetUrl VARCHAR(255) NOT NULL,
    gatewayName VARCHAR(255) NOT NULL,
    details LONGTEXT DEFAULT NULL COMMENT '(DC2Type:object)',
    PRIMARY KEY(hash)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
```

**PostgreSQL**

```sql
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

### Dashboard migration (Experience, Commerce)

If you're using Ibexa Experience or Ibexa Commerce, you must run data migration required by the dashboard and other features to finish the upgrade process:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/dashboard/src/bundle/Resources/migrations/structure.yaml --name=2023_09_23_14_15_dashboard_structure.yaml
php bin/console ibexa:migrations:import vendor/ibexa/dashboard/src/bundle/Resources/migrations/permissions.yaml --name=2023_10_10_16_14_dashboard_permissions.yaml
php bin/console ibexa:migrations:import vendor/ibexa/activity-log/src/bundle/Resources/migrations/dashboard_structure.yaml --name=2023_12_04_13_34_activity_log_dashboard_structure.yaml
php bin/console ibexa:migrations:import vendor/ibexa/personalization/src/bundle/Resources/migrations/dashboard_structure.yaml --name=2023_12_05_17_00_personalization_dashboard_structure.yaml
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/dashboard_structure.yaml --name=2023_11_20_21_32_product_catalog_dashboard_structure.yaml
php bin/console ibexa:migrations:migrate --file=2023_09_23_14_15_dashboard_structure.yaml --file=2023_10_10_16_14_dashboard_permissions.yaml --file=2023_12_04_13_34_activity_log_dashboard_structure.yaml --file=2023_12_05_17_00_personalization_dashboard_structure.yaml --file=2023_11_20_21_32_product_catalog_dashboard_structure.yaml
```

> **Caution: Caution**
>
> The `2023_10_10_16_14_dashboard_permissions.yaml` migration creates a role dedicated for dashboard management and assigns it to the Editors user group. If you have custom user groups which need to manipulate dashboards, you need to skip this migration, copy it to your migrations folder (by default, `src/Migrations/Ibexa/migrations`) and adjust it according to your needs before execution.

For Ibexa Commerce there's an additional migration:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/order-management/src/bundle/Resources/install/migrations/dashboard_structure.yaml --name=2023_11_20_14_33_order_dashboard_structure.yaml
php bin/console ibexa:migrations:migrate --file=2023_11_20_14_33_order_dashboard_structure.yaml
```

### Ibexa Open Source

If you don't have access to Ibexa DXP's `ibexa/installer` package and cannot apply the scripts from `vendor/ibexa/installer` directory, apply the following database update instead:

**MySQL**

```sql
ALTER TABLE `ibexa_token`
ADD COLUMN `revoked` BOOLEAN NOT NULL DEFAULT false;
```

**PostgreSQL**

```sql
ALTER TABLE "ibexa_token"
ADD "revoked" BOOLEAN DEFAULT false NOT NULL;
```

## Revisit configuration

### Revisit mandatory configuration

#### Dashboard configuration (Experience, Commerce)

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

You can use your own content type that represents the back office user, or use the default one provided by Ibexa DXP:

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

#### Activity log (Experience, Commerce)

By default, activity log keeps entries for 30 days. You can change this value by setting `ibexa.repositories.<name>.activity_log.truncate_after_days` parameter:

```yaml
ibexa:
    repositories:
        default:
            # ...
            activity_log:
                truncate_after_days: 10
```

### Revisit permissions

#### Recent activity (Experience, Commerce)

You must add the `Activity Log / Read` policy (`activity_log/read`) to every role that has access to the back office, at least with the "Only own log" limitation. This policy is mandatory to display the "Recent activity" block in [dashboards](#dashboard-migration), and the "Recent activity" block in [user profiles](#user-profile).

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

> **Note: Note**
>
> You can [generate new Solr configuration files using `generate-solr-config.sh`](../../../search/search_engines/solr_search_engine/install_solr/index.md#generate-solr-configuration-automatically), and merge `spellcheck` configuration by comparing new files with your existing setup.

Restart Solr for `solrconfig.xml` changes to take effect.

## Update Elasticsearch schema

Elasticsearch schema's templates change, for example, with the addition of new features such as spellchecking. When this happens, you need to erase the index, update the schema, and rebuild the index.

To delete an index, you can use the Elasticsearch's REST API.

First, use the [`_cat/indices` endpoint](https://www.elastic.co/guide/en/elasticsearch/reference/8.19/cat-indices.html) to list existing indices. For example, the command `curl -H "Accept: application/text" elasticsearch:9200/_cat/indices` returns output like the following:

```bash
yellow open default_location_eng_gb_54 DoSFV-CtQFylKKVvd48YfA 1 1  1 0 16.7kb 16.7kb
yellow open default_location_eng_gb_42 3Z_IrWVHQh2m37jPqQBOcQ 1 1  1 0 20.1kb 20.1kb
yellow open default_content_eng_gb_45  y-t4uNQwR4KRJ-N9i3zUog 1 1  1 0 21.3kb 21.3kb
yellow open default_content_eng_gb_46  e_LS5qG3RIih6iQRPsNp-w 1 1  1 0 22.5kb 22.5kb
yellow open default_content_eng_gb_1   101-1-tQS_2KSvNs2X2JAQ 1 1 17 0 39.8kb 39.8kb
yellow open default_location_eng_gb_46 fSGtpljwTpGfascFechmww 1 1  1 0   21kb   21kb
(...)
```

Create a list containing all indices used by the DXP, including the [custom indices](../../../search/search_engines/elasticsearch/configure_elasticsearch/index.md#define-field-type-mapping-templates) as well.

Then, delete them by using the [delete index endpoint](https://www.elastic.co/guide/en/elasticsearch/reference/8.19/indices-delete-index.html)

```bash
curl --request DELETE 'https://elasticsearch:9200/default_location*'
curl --request DELETE 'https://elasticsearch:9200/default_content*'
(...)
```

> **Tip: Tip**
>
> To quickly delete all existing Elasticsearch indices, you can use the `_all` keyword as the name of the index, as in the following request: `curl --request DELETE https://elasticsearch:9200/_all`. Always review the list of existing indices and confirm they are safe to delete before executing this command, as it permanently removes data.

To update the schema and then reindex the search, use the following commands:

```bash
php bin/console ibexa:elasticsearch:put-index-template --overwrite
php bin/console ibexa:reindex
```

## Update to v4.6.latest

Now, proceed to the last step, [updating to the latest v4.6 patch version](../../from_4.6/update_from_4.6/index.md).
