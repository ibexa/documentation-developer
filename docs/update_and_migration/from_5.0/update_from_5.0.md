---
description: Update your installation to the latest v5.0 version from an earlier v5.0 version.
month_change: true
---

# Update from v5.0.x to v5.0.latest

To update from v4.6.x, see [Update from v4.6 to v5.0](update_to_5.0.md).
To update from an older version, visit [the update page](update_ibexa_dxp.md) and choose the applicable path.

## Update the application

Note which version you actually have before starting.

First, run:

=== "[[= product_name_headless =]]"

    ``` bash
    composer require ibexa/headless:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/headless --force -v
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```
=== "[[= product_name_com =]]"

    ``` bash
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

### Removed support for Elasticsearch 7

As of v5.0.5, Elasticsearch 7 is no longer supported by [[= product_name =]].
If you're using Elasticsearch as your search engine, you must upgrade to Elasticsearch 8.19 or higher.

#### Update Elasticsearch server

Before updating your [[= product_name =]] installation, upgrade your Elasticsearch server to version 8.19 or higher.
Follow the [Elasticsearch upgrade guide](https://www.elastic.co/guide/en/elastic-stack/8.19/upgrading-elastic-stack.html#prepare-to-upgrade) for detailed instructions.

When using [[= product_name_cloud =]], see [Elasticsearch service](https://docs.upsun.com/add-services/elasticsearch.html) for a list of supported versions.

#### Update configuration

Next, you need to update your configuration in `config/packages/ibexa_elasticsearch.yaml`.

##### Update connection pool setting

The `connection_pool` and `connection_selector` settings have been removed and `node_pool_selector` and `node_pool_resurrect` have been added:

``` yaml
# Old configuration (Elasticsearch 7)
ibexa_elasticsearch:
    connections:
        default:
            connection_pool: 'Elasticsearch\ConnectionPool\StaticNoPingConnectionPool'
            connection_selector: 'Elasticsearch\ConnectionPool\Selectors\RoundRobinSelector'
```

``` yaml
# New configuration (Elasticsearch 8)
ibexa_elasticsearch:
    connections:
        default:
            node_pool_selector: 'Elastic\Transport\NodePool\Selector\RoundRobin'
            node_pool_resurrect: 'Elastic\Transport\NodePool\Resurrect\NoResurrect'
```

For more information, see [Node pool](https://www.elastic.co/docs/reference/elasticsearch/clients/php/node_pool#_using_a_custom_nodepool_selector_and_resurrect).

##### Remove trace option

The `trace` configuration option has been removed:

``` yaml
# Old configuration (Elasticsearch 7)
ibexa_elasticsearch:
    connections:
        default:
            debug: true
            trace: true
```

``` yaml
# New configuration (Elasticsearch 8)
ibexa_elasticsearch:
    connections:
        default:
            debug: true
            # trace option removed
```

#### Reindex content

After upgrading to Elasticsearch 8 and updating your configuration, you must reindex the search engine:

1. Push the index templates:

    ``` bash
    php bin/console ibexa:elasticsearch:put-index-template --overwrite
    ```

2. Reindex your content:

    ``` bash
    php bin/console ibexa:reindex
    ```

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

    See [how to configure Anthropic connector](configure_ai_actions.md#install-anthropic-connector) for more information.

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/connector-anthropic:[[= latest_tag_5_0 =]]
    ```

=== "Real-time collaborative editing"

    ### Real-time collaborative editing

    To learn more about the [Real-time editing](collaborative_editing_guide.md), see the [installation and configuration instructions](configure_collaborative_editing.md).

    If you're already using it, run the following command to get the latest version of this feature:

    ```bash
    composer require ibexa/fieldtype-richtext-rte:[[= latest_tag_5_0 =]] ibexa/ckeditor-premium:[[= latest_tag_5_0 =]]
    ```
