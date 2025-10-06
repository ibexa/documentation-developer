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
