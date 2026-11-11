# Update from v5.0.x to v5.0.latest

Update your installation to the latest v5.0 version from an earlier v5.0 version.

To update from v4.6.x, see [Update from v4.6 to v5.0](../../from_4.6/update_to_5.0/index.md). To update from an older version, visit [the update page](../../update_ibexa_dxp/index.md) and choose the applicable path.

## Update the application

Note which version you actually have before starting.

First, run:

**Ibexa Headless**

```bash
yarn upgrade @ibexa/frontend-config @ibexa/ts-config
composer require ibexa/headless:5.0.11 --with-all-dependencies --no-scripts
composer recipes:install ibexa/headless --force -v
```

**Ibexa Experience**

```bash
yarn upgrade @ibexa/frontend-config @ibexa/ts-config
composer require ibexa/experience:5.0.11 --with-all-dependencies --no-scripts
composer recipes:install ibexa/experience --force -v
```

**Ibexa Commerce**

```bash
yarn upgrade @ibexa/frontend-config @ibexa/ts-config
composer require ibexa/commerce:5.0.11 --with-all-dependencies --no-scripts
composer recipes:install ibexa/commerce --force -v
```

Then execute the instructions below starting from the version you're upgrading from.

## v5.0.1

Some packages increase their type hinting strictness. You can run [Ibexa DXP Rector](https://github.com/ibexa/rector/blob/v5.0.1/README.md) to update your code.

## v5.0.2

### Database update

**MySQL**

```sql
CREATE TABLE ibexa_messenger_messages (
    id BIGINT AUTO_INCREMENT NOT NULL,
    body LONGTEXT NOT NULL,
    headers LONGTEXT NOT NULL,
    queue_name VARCHAR(190) NOT NULL,
    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
    INDEX ibexa_messenger_created_at_idx (created_at),
    INDEX ibexa_messenger_available_at_idx (available_at),
    INDEX ibexa_messenger_delivered_at_idx (delivered_at),
    PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;

CREATE TABLE ibexa_messenger_lock_keys (
    key_id VARCHAR(64) NOT NULL,
    key_token VARCHAR(44) NOT NULL,
    key_expiration INT UNSIGNED NOT NULL,
    PRIMARY KEY(key_id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
```

**PostgreSQL**

```bash
CREATE TABLE ibexa_messenger_messages (
    id BIGSERIAL NOT NULL,
    body TEXT NOT NULL,
    headers TEXT NOT NULL,
    queue_name VARCHAR(190) NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
    PRIMARY KEY(id)
);

CREATE INDEX ibexa_messenger_created_at_idx ON ibexa_messenger_messages (created_at);

CREATE INDEX ibexa_messenger_available_at_idx ON ibexa_messenger_messages (available_at);

CREATE INDEX ibexa_messenger_delivered_at_idx ON ibexa_messenger_messages (delivered_at);

COMMENT ON COLUMN ibexa_messenger_messages.created_at IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN ibexa_messenger_messages.available_at IS '(DC2Type:datetime_immutable)';

COMMENT ON COLUMN ibexa_messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)';

CREATE TABLE ibexa_messenger_lock_keys (
    key_id VARCHAR(64) NOT NULL,
    key_token VARCHAR(44) NOT NULL,
    key_expiration INT NOT NULL,
    PRIMARY KEY(key_id)
);
```

On Commerce, run this additional update queries:

**MySQL**

```sql
ALTER TABLE ibexa_discount
    ADD indexed_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)';

CREATE INDEX ibexa_discount_indexed_at_idx
    ON ibexa_discount (indexed_at);
```

**PostgreSQL**

```sql
ALTER TABLE ibexa_discount
    ADD indexed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL;

COMMENT ON COLUMN ibexa_discount.indexed_at IS '(DC2Type:datetime_immutable)';

CREATE INDEX ibexa_discount_indexed_at_idx
    ON ibexa_discount (indexed_at);
```

## v5.0.3

### Form Builder performance fix: missing indexes on form submission data (Experience, Commerce)

In large production databases, the `ibexa_form_submission` and `ibexa_form_submission_data` tables may contain a lot of rows. Missing indexes can cause high CPU load and slow queries.

Run the provided SQL upgrade script to add the missing indexes to your database:

**MySQL**

```sql
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.2-to-5.0.3.sql
```

**PostgreSQL**

```sql
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.2-to-5.0.3.sql
```

## v5.0.4

### Database update (Experience, Commerce)

From a platform first installed on v5.0.3 or updated precisely to v5.0.3, you need to execute the requests below. If the platform comes from lower than v5.0.3 and is updated to higher than v5.0.3, you don't need this part (but if you run the requests anyway, you only obtain error messages, nothing being broken or lost).

**MySQL**

```sql
ALTER TABLE `ibexa_site_public_access` ADD COLUMN `tree_root_location_id` INT DEFAULT NULL;
ALTER TABLE `ibexa_site_public_access` ADD INDEX `ibexa_spa_trl_id` (`tree_root_location_id`);

UPDATE ibexa_site_public_access
  SET tree_root_location_id = CAST(JSON_UNQUOTE(JSON_EXTRACT(config, '$."ibexa.site_access.config.content.tree_root.location_id"')) AS SIGNED)
  WHERE tree_root_location_id IS NULL AND JSON_EXTRACT(config, '$."ibexa.site_access.config.content.tree_root.location_id"') IS NOT NULL;
```

**PostgreSQL**

```sql
ALTER TABLE ibexa_site_public_access ADD COLUMN tree_root_location_id INT DEFAULT NULL;
CREATE INDEX "ibexa_spa_trl_id" ON "ibexa_site_public_access" ("tree_root_location_id");

UPDATE ibexa_site_public_access
  SET tree_root_location_id = (config::jsonb ->> 'ibexa.site_access.config.content.tree_root.location_id')::integer
  WHERE tree_root_location_id IS NULL AND config::jsonb ? 'ibexa.site_access.config.content.tree_root.location_id';
```

## v5.0.5

### Elasticsearch 8 support

As of v5.0.5, Ibexa DXP adds support for Elasticsearch 8.19 or higher. You can continue using [unsupported Elasticsearch 7.16.2+](https://www.elastic.co/support/eol), but it's recommended to upgrade to Elasticsearch 8 for improved performance and security features.

When choosing to keep using Elasticsearch 7.16.2, adjust your configuration as described in the [Update configuration](#update-configuration) section below to avoid using deprecated settings.

If you choose to upgrade to Elasticsearch 8, follow these steps:

#### Update Elasticsearch server

Upgrade your Elasticsearch server to version 8.19 or higher. For detailed instructions, follow the [Elasticsearch upgrade guide](https://www.elastic.co/guide/en/elastic-stack/8.19/upgrading-elastic-stack.html#prepare-to-upgrade).

When you use Ibexa Cloud, see [Elasticsearch service](https://developer.upsun.com/docs/add-services/elasticsearch) for a list of supported versions.

#### Update configuration

Update your configuration in `config/packages/ibexa_elasticsearch.yaml`.

##### Replace deprecated connection pool settings

The deprecated `connection_pool` and `connection_selector` settings are now ignored and don't have any effect. Replace them with appropriate `node_pool_selector` and `node_pool_resurrect` settings:

```yaml
# Old configuration (Elasticsearch 7 - deprecated)
ibexa_elasticsearch:
    connections:
        default:
            connection_pool: 'Elasticsearch\ConnectionPool\StaticNoPingConnectionPool'
            connection_selector: 'Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector'
```

```yaml
# New configuration (Elasticsearch 7 and 8)
ibexa_elasticsearch:
    connections:
        default:
            node_pool_selector: 'Elastic\Transport\NodePool\Selector\RoundRobin'
            node_pool_resurrect: 'Elastic\Transport\NodePool\Resurrect\NoResurrect'
```

For more information, see [Node pool settings](../../../search/search_engines/elasticsearch/configure_elasticsearch/index.md#node-pool-settings).

##### Remove trace option

The `trace` debugging option is no longer available.

```yaml
# Old configuration (Elasticsearch 7)
ibexa_elasticsearch:
    connections:
        default:
            debug: true
            trace: true
```

```yaml
# New configuration (Elasticsearch 7 and 8)
ibexa_elasticsearch:
    connections:
        default:
            debug: true
            # Trace option is no longer available
```

#### Reindex content

After upgrading to Elasticsearch 8 and updating your configuration, reindex the search engine:

1. Push the index templates:

   ```bash
   php bin/console ibexa:elasticsearch:put-index-template --overwrite
   ```

2. Reindex your content:

   ```bash
   php bin/console ibexa:reindex
   ```

### Database update

Run the provided SQL upgrade script to ensure the Messenger tables for [background tasks](../../../infrastructure_and_maintenance/background_tasks/index.md) exist in your database:

**MySQL**

```sql
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.4-to-5.0.5.sql
```

**PostgreSQL**

```sql
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.4-to-5.0.5.sql
```

## v5.0.6

### Database update (Experience, Commerce)

Run the provided SQL upgrade script to adapt your database to latest change in [form builder](../../../content_management/forms/form_builder_guide/index.md)'s `max_length` validator behavior:

**MySQL**

```sql
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.5-to-5.0.6.sql
```

**PostgreSQL**

```sql
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.5-to-5.0.6.sql
```

Prior, `0` was interpreted as "no length limit". Now, `0` is interpreted as "length limited to zero characters" and `NULL` as "no length limit".

### Ibexa Cloud configuration update

If you're using Ibexa Cloud, you must install a new package and update your cloud configuration.

First, install the `ibexa/cloud` package:

```bash
composer require ibexa/cloud
```

Then, update your cloud configuration. Instead of the old `composer ibexa:setup --platformsh` command, use:

```bash
php bin/console ibexa:cloud:setup --upsun
```

This command generates or updates the cloud configuration files.

Additionally, you must remove the following line from your `.platform.app.yaml` file if it exists:

```yaml
curl -fs https://get.symfony.com/cloud/configurator | bash
```

## v5.0.7

### Update Symfony from 7.3 to 7.4

This version of Ibexa DXP requires [Symfony 7.4](https://symfony.com/releases/7.4). Update Symfony constraints in `composer.json` before updating the packages.

1. In `composer.json`, update `extra.symfony.require` to allow installing a higher Symfony version:

   ```json
   "extra": {
       "symfony": {
           "require": "7.4.*"
       }
   }
   ```

2. To allow installing Symfony 7.4, update the requirements for **all** `symfony` packages in `composer.json` as in the example below:

   ```diff
   -        "symfony/<package>"": "7.3.*",
   +        "symfony/<package>"": "7.4.*",
   ```

3. Review your code, configuration, and third-party bundles for Symfony 7.4 compatibility.

   For more details about the new version, see the official Symfony [upgrade instructions](https://github.com/symfony/symfony/blob/7.4/UPGRADE-7.4.md) and [blog posts introducing this release](https://symfony.com/blog/category/living-on-the-edge/8.0-7.4). Key changes include:

   - Independent application cache directory

     Symfony 7.4 introduces a new [share directory](https://symfony.com/blog/new-in-symfony-7-4-share-directory), dedicated for storing application cache on the file system. If you decide to configure it (for example, by setting the `APP_SHARE_DIR` environment variable), review your existing scripts for explicit `var/cache` usage (for example, `rm -rf var/cache`) and decide whether to include `var/share` in the script.

     If you use Ibexa Cloud, add a mount for the `var/share` directory to your `.platform.app.yaml` file, next to the existing `var/cache` and `var/log` mounts:

     ```yaml
     mounts:
         'var/cache':
             source: local
             source_path: cache
         'var/share':
             source: local
             source_path: share
         'var/log':
             source: local
             source_path: log
     ```

     Without this mount, the `var/share` directory is read-only and all writes to the `cache.app` cache pool fail.

     > **Caution: Always clear the persistence cache withcache:pool:clearcommand**
     >
     > Starting with Symfony 7.4, running `php bin/console cache:clear` doesn't clear the Ibexa DXP persistence cache, even when using a filesystem-based cache pool.
     >
     > To clear the persistence cache, for example after adding a [custom Page Builder block](../../../content_management/pages/create_custom_page_block/index.md), you must always run:
     >
     > ```bash
     > php bin/console cache:pool:clear <cache-pool>
     > ```
     >
     > The default cache pool is named `cache.tagaware.filesystem`. The default cache pool when running Redis or Valkey is named `cache.redis`. If you have customized the persistence cache configuration, the name of your cache pool might be different.
     >
     > For more information about persistence cache, see [Persistence cache](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md).

   - Array-based PHP configuration format

     As part of the new [array-based PHP configuration format](https://symfony.com/blog/new-in-symfony-7-4-better-php-configuration), Symfony creates the `config/reference.php` file. Consider committing this file to the repository.

4. Update Ibexa packages by running:

   **Ibexa Headless**

   ```bash
   yarn upgrade @ibexa/frontend-config @ibexa/ts-config
   composer require ibexa/headless:v5.0.7 --with-all-dependencies --no-scripts
   composer recipes:install ibexa/headless --force -v
   ```

   **Ibexa Experience**

   ```bash
   yarn upgrade @ibexa/frontend-config @ibexa/ts-config
   composer require ibexa/experience:v5.0.7 --with-all-dependencies --no-scripts
   composer recipes:install ibexa/experience --force -v
   ```

   **Ibexa Commerce**

   ```bash
   yarn upgrade @ibexa/frontend-config @ibexa/ts-config
   composer require ibexa/commerce:v5.0.7 --with-all-dependencies --no-scripts
   composer recipes:install ibexa/commerce --force -v
   ```

5. Manually restore the entry for `JMSTranslationBundle` in `config/bundles.php` to [its previous position](https://github.com/ibexa/commerce-skeleton/blob/v5.0.6/config/bundles.php#L14):

   ```text
       FOS\HttpCacheBundle\FOSHttpCacheBundle::class => ['all' => true],
       JMS\TranslationBundle\JMSTranslationBundle::class => ['all' => true],
       Liip\ImagineBundle\LiipImagineBundle::class => ['all' => true],
   ```

You're now running [Symfony 7.4, the current long-term support version](https://symfony.com/releases/7.4).

### Ibexa Cloud `ibexa:setup` command deprecation

Following the changes introduced in v5.0.6, the `ibexa:setup` command is deprecated as of v5.0.7 and will be removed in v6.0.0. Additionally, the `ibexa/cloud` package must be installed for the Ibexa Cloud build to succeed. The command `ibexa:cloud:setup` from this package replaces the deprecated `ibexa:setup`.

To learn how to adjust your configuration, see [update instructions for v5.0.6](#ibexa-cloud-configuration-update).

### Database update (Experience, Commerce)

Run the provided SQL upgrade script to update your database:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.6-to-5.0.7.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.6-to-5.0.7.sql
```

## v5.0.8

### VCL configuration

When using Varnish or Fastly, update your [VCL files](../../../infrastructure_and_maintenance/cache/http_cache/reverse_proxy/index.md#vcl-base-files) to align with the ones from [`vendor/ibexa/http-cache/docs/varnish/vcl/`](https://github.com/ibexa/http-cache/tree/v5.0.8/docs/varnish/vcl) or `vendor/ibexa/fastly/fastly/`, especially if you plan to use the [Anonymous user segmentation in Ibexa CDP](../../../cdp/cdp_activation/cdp_configuration/index.md#anonymous-user-segmentation). Make sure it contains the highlighted addition:

```vcl
        set req.http.cookie = regsuball(req.http.cookie, ";(ibexa[-_][^=]*)=", "; \1=");
        // Keep the Raptor anonymous visitor identifier cookie so CDP segmentation can resolve visitor segments.
        set req.http.cookie = regsuball(req.http.cookie, ";(rsa)=", "; \1=");
        set req.http.cookie = regsuball(req.http.cookie, ";[^ ][^;]*", "");
```

## v5.0.9

No additional steps needed for Ibexa DXP, but the [MCP Servers LTS Update requires additional update steps](#mcp-servers) if you're using it.

## v5.0.10

No additional steps needed for Ibexa DXP.

> **Note: Database upgrade scripts**
>
> The `vendor/ibexa/installer/upgrade/db` contains the `ibexa-5.0.9-to-5.0.10.sql` database update script. You don't need to run it. The tables added by the script are required only by the [Translation Management LTS update](../../../multisite/translations_management/translations_management/index.md) and adding them is part of its [configuration procedure](../../../multisite/translations_management/configure_translations_management/index.md#modify-database-schema).

## v5.0.11

### node.js update

Node.js [requirement](../../../getting_started/requirements/index.md#asset-manager) has changed. Update node.js to version 24 or higher to avoid issues with asset management.

### Database update

With v5.0.11, Ibexa introduces Doctrine migrations to manage database schema changes. With Ibexa Doctrine migrations, you no longer have to manually run the SQL upgrade scripts. The `ibexa/doctrine-migrations` package is installed automatically as a dependency of Ibexa DXP's packages, so no separate installation step is required.

Ibexa Doctrine migrations cover every SQL upgrade script previously listed in this guide.

> **Caution: Caution**
>
> Always back up your data before running any database update scripts.
>
> After updating the database, clear the cache.
>
> Don't use `--force` argument for `mysql` / `psql` commands when performing update queries. If there is any problem during the update, it's best if the query fails immediately, so you can fix the underlying problem before you execute the update again. If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.

To preview the migrations before you apply them, run:

```bash
php bin/console ibexa:doctrine:migrations:migrate --dry-run --write-sql=var/migration-preview.sql
```

> **Caution: Preview only**
>
> This generates an SQL file that is only intended for review. More recent migrations can be unaware of changes made by earlier migrations in the same run, so the file may be incomplete. Do not run the SQL file against your database.
>
> Always apply changes by running the command without the `--dry-run` flag.

Run the following command to apply all database migrations present in your currently installed code:

```bash
php bin/console ibexa:doctrine:migrations:migrate
```

> **Tip: Apply migrations one by one**
>
> Instead of applying all pending migrations at once, you can go through them one at a time. To preview only the next pending migration, run:
>
> ```bash
> php bin/console ibexa:doctrine:migrations:migrate next --dry-run
> ```
>
> Then, to apply it, run the same command without the `--dry-run` option:
>
> ```bash
> php bin/console ibexa:doctrine:migrations:migrate next
> ```
>
> Repeat these steps until no pending migrations remain. To check which migrations are still pending, run `php bin/console ibexa:doctrine:migrations:status`.

If your project uses [multiple repositories](../../../administration/configuration/repository_configuration/index.md#defining-custom-connection) with separate databases, run the command once for each repository, using the `--siteaccess` option with any SiteAccess that belongs to that repository:

```bash
php bin/console ibexa:doctrine:migrations:migrate --siteaccess=<siteaccess_of_that_repository>
```

Running the command more than once is safe. It has no effect if you apply it to a SiteAccess whose repository has already been migrated.

Ibexa Doctrine migrations only manage Ibexa DXP's own database tables. Your custom tables are not affected, even if you manage them with standard Doctrine migrations.

> **Caution: Command scope**
>
> This command isn't a full schema conformity checker. It checks for the presence of key elements (such as a column or table) to determine whether a change has already been applied. If a past upgrade was partially applied to your database, Doctrine migrations can be misled into marking the migration as complete when it isn't.
>
> Always back up your database and test the `ibexa:doctrine:migrations:migrate` command in a non-production environment first.

> **Note: Resolving conflicts with customizations**
>
> If a migration fails because you already modified the affected table yourself, for example, as part of a customization, check the error, compare with the SQL file generated during the dry run, and resolve the issue. Then, try running `ibexa:doctrine:migrations:migrate` again. Most migrations check the current state of the schema and record themselves as executed when it matches, without making any changes.
>
> If the migration still fails, check what it does, and make sure your schema reflects the same end result. Then, mark that migration as executed without actually running it.
>
> ```bash
> php bin/console ibexa:doctrine:migrations:version --add 'Ibexa\Bundle\Taxonomy\Migration\AddTaxonomyEntriesRootIndexesMigration'
> ```

### Flysystem 3 support

Ibexa DXP 5.0 requires PHP 8.3 or later, therefore, as of v.5.0.11, `league/flysystem` installs as 3.36 or later by default. However, Flysystem 2.5 is also supported to provide backward compatibility.

> **Note: Custom and local adapters**
>
> - If you have a custom adapter, any class that implements `League\Flysystem\FilesystemAdapter` must add `directoryExists(string $path): bool`. Otherwise, Flysystem 3 throws a fatal error.
> - If you use `league/flysystem-aws-s3-v3`, `-azure-blob-storage`, `-google-cloud-storage`, `-sftp-v3`, or a similar cloud adapter, these are versioned together with Flysystem. If your project still requires a `2.x` adapter, Composer silently keeps Flysystem on 2.5, and you must bump the adapter requirement manually to `^3.0` to get Flysystem 3.x.
> - If you use Flysystem's `local` adapter type as an IO handler, it only accepts `mimeTypeDetector` as a string, so a detector service can't be configured through it directly. Flysystem 3.x's default detector returns no MIME type for ambiguous files, such as extensionless text or empty files, which can cause downloads to fail. To preserve the previous behavior, define your own service for `League\Flysystem\Local\LocalFilesystemAdapter` with `$mimeTypeDetector` set to `League\MimeTypeDetection\FinfoMimeTypeDetector`, then configure it as a `custom` adapter pointing to that service instead of `local`. Ibexa DXP's own adapters already do this.

### Ibexa Cloud VCL update

On Ibexa Cloud, Ibexa DXP now detects requests that come from Fastly and automatically trusts the proxy headers set by the router. This works only if `framework.trusted_proxies` isn't empty (`TRUSTED_PROXIES` defaults to `127.0.0.1` in `.env`).

If you're using Ibexa Cloud, regenerate your cloud configuration to get the latest VCL files:

```bash
php bin/console ibexa:cloud:setup --upsun
```

For more information, see [Configure Symfony front controller](../../../infrastructure_and_maintenance/cache/http_cache/reverse_proxy/index.md#configure-symfony-front-controller).

### CKEditor 5 update

[Online Editor](../../../content_management/rich_text/online_editor_guide/index.md) now uses version v48.5.1 of CKEditor 5 as its base.

If your system uses custom CKEditor plugins, ensure that they use the updated version of CKEditor dependencies.

## LTS Updates and additional packages

[LTS Updates](../../../ibexa_products/editions/index.md#lts-updates) are standalone packages with their own update procedures. To use the [latest features](../../../release_notes/ibexa_dxp_v5.0/index.md) added to them, update them separately with the following commands:

**Integrated help**

### Integrated help (LTS Update)

See [Integrated help](../../../administration/back_office/integrated_help/index.md) for more information.

If you're already using it, run the following command to get the latest version of this feature:

```bash
composer require ibexa/integrated-help:5.0.11
```

**Anthropic connector**

### Anthropic connector (LTS Update)

See [how to configure Anthropic connector](../../../ai/ai_actions/configure_ai_actions/index.md#install-anthropic-connector) for more information.

If you're already using it, run the following command to get the latest version of this feature:

```bash
composer require ibexa/connector-anthropic:5.0.11
```

**Real-time collaborative editing**

### Real-time collaborative editing

To learn more about the [Real-time editing](../../../content_management/collaborative_editing/collaborative_editing_guide/index.md), see the [installation and configuration instructions](../../../content_management/collaborative_editing/configure_collaborative_editing/index.md).

If you're already using it, run the following command to get the latest version of this feature:

```bash
composer require ibexa/fieldtype-richtext-rte:5.0.11 ibexa/ckeditor-premium:5.0.11
```

**MCP Servers**

### MCP Servers

To learn more about the [MCP Servers](../../../ai/mcp/mcp_guide/index.md), see the [installation and configuration instructions](../../../ai/mcp/mcp_config/index.md).

If you're already using it, run the following command to get the latest version of this feature:

```bash
composer require ibexa/mcp:5.0.11
```

#### v5.0.9

Between v5.0.8 and v5.0.9, the following changes were made to the MCP Servers feature:

- An [`allowed_hosts`](../../../ai/mcp/mcp_config/index.md#allowed-hosts) setting has been added, restricting usage to localhost by default. Customize this value to allow more hosts.
- The [built-in tool](../../../ai/mcp/mcp_config/index.md#built-in-tools) `list_content_translations` is now renamed to `list_content_languages`.
