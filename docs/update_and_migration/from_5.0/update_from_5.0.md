---
description: Update your installation to the latest v5.0 version from an earlier v5.0 version.
month_change: false
---

# Update from v5.0.x to v5.0.latest

To update from v4.6.x, see [Update from v4.6 to v5.0](update_to_5.0.md).
To update from an older version, visit [the update page](update_ibexa_dxp.md) and choose the applicable path.

## Update the application

Note which version you actually have before starting.

First, run:

=== "[[= product_name_headless =]]"

    ``` bash
    yarn upgrade @ibexa/frontend-config @ibexa/ts-config
    composer require ibexa/headless:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/headless --force -v
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    yarn upgrade @ibexa/frontend-config @ibexa/ts-config
    composer require ibexa/experience:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```
=== "[[= product_name_com =]]"

    ``` bash
    yarn upgrade @ibexa/frontend-config @ibexa/ts-config
    composer require ibexa/commerce:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

Then execute the instructions below starting from the version you're upgrading from.

<!-- vale Ibexa.VariablesVersion = NO -->

## v5.0.1

Some packages increase their type hinting strictness.
You can run [Ibexa DXP Rector](https://github.com/ibexa/rector/blob/v5.0.1/README.md) to update your code.

## v5.0.2

### Database update

=== "MySQL"

    ``` sql
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

=== "PostgreSQL"

    ``` bash
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

=== "MySQL"

    ``` sql
    ALTER TABLE ibexa_discount
        ADD indexed_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)';

    CREATE INDEX ibexa_discount_indexed_at_idx
        ON ibexa_discount (indexed_at);
    ```

=== "PostgreSQL"

    ``` sql
    ALTER TABLE ibexa_discount
        ADD indexed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL;

    COMMENT ON COLUMN ibexa_discount.indexed_at IS '(DC2Type:datetime_immutable)';

    CREATE INDEX ibexa_discount_indexed_at_idx
        ON ibexa_discount (indexed_at);
    ```

## v5.0.3

### Form Builder performance fix: missing indexes on form submission data [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

In large production databases, the `ibexa_form_submission` and `ibexa_form_submission_data` tables may contain a lot of rows.
Missing indexes can cause high CPU load and slow queries.

Run the provided SQL upgrade script to add the missing indexes to your database:

=== "MySQL"

    ``` sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.2-to-5.0.3.sql
    ```

=== "PostgreSQL"

    ``` sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.2-to-5.0.3.sql
    ```

## v5.0.4

### Database update [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

From a platform first installed on v5.0.3 or updated precisely to v5.0.3, you need to execute the requests below.
If the platform comes from lower than v5.0.3 and is updated to higher than v5.0.3, you don't need this part
(but if you run the requests anyway, you only obtain error messages, nothing being broken or lost).

=== "MySQL"

    ``` sql
    ALTER TABLE `ibexa_site_public_access` ADD COLUMN `tree_root_location_id` INT DEFAULT NULL;
    ALTER TABLE `ibexa_site_public_access` ADD INDEX `ibexa_spa_trl_id` (`tree_root_location_id`);

    UPDATE ibexa_site_public_access
      SET tree_root_location_id = CAST(JSON_UNQUOTE(JSON_EXTRACT(config, '$."ibexa.site_access.config.content.tree_root.location_id"')) AS SIGNED)
      WHERE tree_root_location_id IS NULL AND JSON_EXTRACT(config, '$."ibexa.site_access.config.content.tree_root.location_id"') IS NOT NULL;
    ```

=== "PostgreSQL"

    ``` sql
    ALTER TABLE ibexa_site_public_access ADD COLUMN tree_root_location_id INT DEFAULT NULL;
    CREATE INDEX "ibexa_spa_trl_id" ON "ibexa_site_public_access" ("tree_root_location_id");

    UPDATE ibexa_site_public_access
      SET tree_root_location_id = (config::jsonb ->> 'ibexa.site_access.config.content.tree_root.location_id')::integer
      WHERE tree_root_location_id IS NULL AND config::jsonb ? 'ibexa.site_access.config.content.tree_root.location_id';
    ```

## v5.0.5

### Elasticsearch 8 support

As of v5.0.5, [[= product_name =]] adds support for Elasticsearch 8.19 or higher.
You can continue using [unsupported Elasticsearch 7.16.2+](https://www.elastic.co/support/eol), but it's recommended to upgrade to Elasticsearch 8 for improved performance and security features.

When choosing to keep using Elasticsearch 7.16.2, adjust your configuration as described in the [Update configuration](#update-configuration) section below to avoid using deprecated settings.

If you choose to upgrade to Elasticsearch 8, follow these steps:

#### Update Elasticsearch server

Upgrade your Elasticsearch server to version 8.19 or higher.
For detailed instructions, follow the [Elasticsearch upgrade guide](https://www.elastic.co/guide/en/elastic-stack/8.19/upgrading-elastic-stack.html#prepare-to-upgrade).

When you use [[= product_name_cloud =]], see [Elasticsearch service](https://docs.upsun.com/add-services/elasticsearch.html) for a list of supported versions.

#### Update configuration

Update your configuration in `config/packages/ibexa_elasticsearch.yaml`.

##### Replace deprecated connection pool settings

The deprecated `connection_pool` and `connection_selector` settings are now ignored and don't have any effect.
Replace them with appropriate `node_pool_selector` and `node_pool_resurrect` settings:

``` yaml
# Old configuration (Elasticsearch 7 - deprecated)
ibexa_elasticsearch:
    connections:
        default:
            connection_pool: 'Elasticsearch\ConnectionPool\StaticNoPingConnectionPool'
            connection_selector: 'Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector'
```

``` yaml
# New configuration (Elasticsearch 7 and 8)
ibexa_elasticsearch:
    connections:
        default:
            node_pool_selector: 'Elastic\Transport\NodePool\Selector\RoundRobin'
            node_pool_resurrect: 'Elastic\Transport\NodePool\Resurrect\NoResurrect'
```

For more information, see [Node pool settings](https://doc.ibexa.co/en/latest/search/search_engines/elasticsearch/configure_elasticsearch/#node-pool-settings).

##### Remove trace option

The `trace` debugging option is no longer available.

``` yaml
# Old configuration (Elasticsearch 7)
ibexa_elasticsearch:
    connections:
        default:
            debug: true
            trace: true
```

``` yaml
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

    ``` bash
    php bin/console ibexa:elasticsearch:put-index-template --overwrite
    ```

2. Reindex your content:

    ``` bash
    php bin/console ibexa:reindex
    ```

### Database update

Run the provided SQL upgrade script to ensure the Messenger tables for [background tasks](background_tasks.md) exist in your database:

=== "MySQL"

    ``` sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.4-to-5.0.5.sql
    ```

=== "PostgreSQL"

    ``` sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.4-to-5.0.5.sql
    ```

## v5.0.6

### Database update [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Run the provided SQL upgrade script to adapt your database to latest change in [form builder](form_builder_guide.md)'s `max_length` validator behavior:

=== "MySQL"

    ``` sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.5-to-5.0.6.sql
    ```

=== "PostgreSQL"

    ``` sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.5-to-5.0.6.sql
    ```

Prior, `0` was interpreted as "no length limit".
Now, `0` is interpreted as "length limited to zero characters" and `NULL` as "no length limit".

### [[= product_name_cloud =]] configuration update

If you're using [[= product_name_cloud =]], you must install a new package and update your cloud configuration.

First, install the `ibexa/cloud` package:

```bash
composer require ibexa/cloud
```

Then, update your cloud configuration.
Instead of the old `composer ibexa:setup --platformsh` command, use:

``` bash
php bin/console ibexa:cloud:setup --upsun
```

This command generates or updates the cloud configuration files.

Additionally, you must remove the following line from your `.platform.app.yaml` file if it exists:

```yaml
curl -fs https://get.symfony.com/cloud/configurator | bash
```

## v5.0.7

### Update Symfony from 7.3 to 7.4

This version of [[= product_name =]] requires [Symfony 7.4](https://symfony.com/releases/7.4).
Update Symfony constraints in `composer.json` before updating the packages.

1. In `composer.json`, update `extra.symfony.require` to allow installing a higher Symfony version:

    ```json
    "extra": {
        "symfony": {
            "require": "7.4.*"
        }
    }
    ```

2. To allow installing Symfony 7.4, update the requirements for **all** `symfony` packages in `composer.json` as in the example below:

    ``` diff
    -        "symfony/<package>"": "7.3.*",
    +        "symfony/<package>"": "7.4.*",
    ```

3. Review your code, configuration, and third-party bundles for Symfony 7.4 compatibility.

    For more details about the new version, see the official Symfony [upgrade instructions](https://github.com/symfony/symfony/blob/7.4/UPGRADE-7.4.md) and [blog posts introducing this release](https://symfony.com/blog/category/living-on-the-edge/8.0-7.4).
    Key changes include:


    - Independent application cache directory

        Symfony 7.4 introduces a new [share directory](https://symfony.com/blog/new-in-symfony-7-4-share-directory), dedicated for storing application cache on the file system.
        If you decide to configure it (for example, by setting the `APP_SHARE_DIR` environment variable), review your existing scripts for explicit `var/cache` usage (for example, `rm -rf var/cache`) and decide whether to include `var/share` in the script.

        !!! caution "Always clear the persistence cache with `cache:pool:clear` command"

            Starting with Symfony 7.4, running `php bin/console cache:clear` doesn't clear the [[= product_name =]] persistence cache, even when using a filesystem-based cache pool.

            To clear the persistence cache, for example after adding a [custom Page Builder block](create_custom_page_block.md), you must always run:

            ```bash
            php bin/console cache:pool:clear <cache-pool>
            ```

            The default cache pool is named `cache.tagaware.filesystem`.
            The default cache pool when running Redis or Valkey is named `cache.redis`.
            If you have customized the persistence cache configuration, the name of your cache pool might be different.

            For more information about persistence cache, see [Persistence cache](persistence_cache.md).

    - Array-based PHP configuration format

        As part of the new [array-based PHP configuration format](https://symfony.com/blog/new-in-symfony-7-4-better-php-configuration), Symfony creates the `config/reference.php` file.
        Consider committing this file to the repository.

4. Update Ibexa packages by running:

    === "[[= product_name_headless =]]"

        ``` bash
        yarn upgrade @ibexa/frontend-config @ibexa/ts-config
        composer require ibexa/headless:v5.0.7 --with-all-dependencies --no-scripts
        composer recipes:install ibexa/headless --force -v
        ```
    === "[[= product_name_exp =]]"

        ``` bash
        yarn upgrade @ibexa/frontend-config @ibexa/ts-config
        composer require ibexa/experience:v5.0.7 --with-all-dependencies --no-scripts
        composer recipes:install ibexa/experience --force -v
        ```
    === "[[= product_name_com =]]"

        ``` bash
        yarn upgrade @ibexa/frontend-config @ibexa/ts-config
        composer require ibexa/commerce:v5.0.7 --with-all-dependencies --no-scripts
        composer recipes:install ibexa/commerce --force -v
        ```

5. Manually restore the entry for `JMSTranslationBundle` in `config/bundles.php` to [its previous position](https://github.com/ibexa/commerce-skeleton/blob/v5.0.6/config/bundles.php#L14):

    ``` hl_lines="2"
        FOS\HttpCacheBundle\FOSHttpCacheBundle::class => ['all' => true],
        JMS\TranslationBundle\JMSTranslationBundle::class => ['all' => true],
        Liip\ImagineBundle\LiipImagineBundle::class => ['all' => true],
    ```

You're now running [Symfony 7.4, the current long-term support version](https://symfony.com/releases/7.4).

### [[= product_name_cloud =]] `ibexa:setup` command deprecation

Following the changes introduced in v5.0.6, the `ibexa:setup` command is deprecated as of v5.0.7 and will be removed in v6.0.0.
Additionally, the `ibexa/cloud` package must be installed for the [[= product_name_cloud =]] build to succeed.
The command `ibexa:cloud:setup` from this package replaces the deprecated `ibexa:setup`.

To learn how to adjust your configuration, see [update instructions for v5.0.6](#ibexa-cloud-configuration-update).

### Database update [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Run the provided SQL upgrade script to update your database:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-5.0.6-to-5.0.7.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-5.0.6-to-5.0.7.sql
    ```

## v5.0.8

### VCL configuration

When using Varnish or Fastly, update your [VCL files](reverse_proxy.md#vcl-base-files) to align with the ones from [`vendor/ibexa/http-cache/docs/varnish/vcl/`](https://github.com/ibexa/http-cache/tree/v5.0.8/docs/varnish/vcl) or `vendor/ibexa/fastly/fastly/`,
especially if you plan to use the [Anonymous user segmentation in [[= product_name_cdp =]]](https://doc.ibexa.co/en/5.0/cdp/cdp_activation/cdp_configuration/#anonymous-user-segmentation).
Make sure it contains the highlighted addition:

``` vcl hl_lines="2 3"
        set req.http.cookie = regsuball(req.http.cookie, ";(ibexa[-_][^=]*)=", "; \1=");
        // Keep the Raptor anonymous visitor identifier cookie so CDP segmentation can resolve visitor segments.
        set req.http.cookie = regsuball(req.http.cookie, ";(rsa)=", "; \1=");
        set req.http.cookie = regsuball(req.http.cookie, ";[^ ][^;]*", "");
```

## v5.0.9

No additional steps needed for [[= product_name =]], but the [MCP Servers LTS Update requires additional update steps](#mcp-servers) if you're using it.

## v5.0.10

No additional steps needed for [[= product_name =]].

## LTS Updates and additional packages

[LTS Updates](editions.md#lts-updates) are standalone packages with their own update procedures.
To use the [latest features](ibexa_dxp_v5.0.md) added to them, update them separately with the following commands:

=== "Integrated help"

    ### Integrated help [[% include 'snippets/lts-update_badge.md' %]]

    See [Integrated help](integrated_help.md) for more information.

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/integrated-help:[[= latest_tag_5_0 =]]
    ```

=== "Anthropic connector"

    ### Anthropic connector [[% include 'snippets/lts-update_badge.md' %]]

    See [how to configure Anthropic connector](https://doc.ibexa.co/en/5.0/ai_actions/configure_ai_actions/#install-anthropic-connector) for more information.

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/connector-anthropic:[[= latest_tag_5_0 =]]
    ```

=== "Real-time collaborative editing"

    ### Real-time collaborative editing

    To learn more about the [Real-time editing](collaborative_editing_guide.md), see the [installation and configuration instructions](https://doc.ibexa.co/en/5.0/content_management/collaborative_editing/configure_collaborative_editing/).

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/fieldtype-richtext-rte:[[= latest_tag_5_0 =]] ibexa/ckeditor-premium:[[= latest_tag_5_0 =]]
    ```

=== "MCP Servers"

    ### MCP Servers

    To learn more about the [MCP Servers](https://doc.ibexa.co/en/5.0/ai/mcp/mcp_guide/), see the [installation and configuration instructions](https://doc.ibexa.co/en/5.0/ai/mcp/mcp_config/).

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/mcp:[[= latest_tag_5_0 =]]
    ```

    #### v5.0.9

    Between v5.0.8 and v5.0.9, the following changes were made to the MCP Servers feature:

    - An [`allowed_hosts`](https://doc.ibexa.co/en/5.0/ai/mcp/mcp_config#allowed-hosts) setting has been added, restricting usage to localhost by default. Customize this value to allow more hosts.
    - The [built-in tool](https://doc.ibexa.co/en/5.0/ai/mcp/mcp_config#built-in-tools) `list_content_translations` is now renamed to `list_content_languages`.
