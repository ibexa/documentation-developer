---
description: Use Ibexa Messenger to run processes in the background and conserve system resources.
month_change: false
---

# Background tasks

Some operations in [[= product_name =]] don’t have to run immediately when a user clicks a button, for example, re-indexing product prices or processing bulk data.
Running such operations in real time could slow down the system and disrupt the user experience.

To solve this, [[= product_name =]] provides a package called [[= product_name_base =]] Messenger, which is an overlay to [Symfony Messenger]([[= symfony_doc =]]/messenger.html), and it's job is to queue tasks and run them in the background.
[[= product_name =]] sends messages (or commands) that represent the work to be done later.
These messages are stored in a queue and picked up by a background worker, which ensures that resource-heavy tasks are executed at a convenient time, without putting excessive load on the system.

[[= product_name_base =]] Messenger supports multiple storage backends, such as Doctrine, Redis/Valkey, and PostgreSQL, and gives developers the flexibility to create their own message handlers for custom use cases.

## Installation

To use [[= product_name_base =]] Messenger, you must first install the package and set up the database tables.

### Install package

Install the `ibexa/messenger` package:

```bash
composer require ibexa/messenger:[[= latest_tag_4_6 =]]
```

### Set up database

Run the following SQL script to create the required database tables.

=== "MySQL"

    ```sql
    -- ibexa/messenger
    CREATE TABLE IF NOT EXISTS ibexa_messenger_messages (
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

    CREATE TABLE IF NOT EXISTS ibexa_messenger_lock_keys (
        key_id VARCHAR(64) NOT NULL,
        key_token VARCHAR(44) NOT NULL,
        key_expiration INT UNSIGNED NOT NULL,
        PRIMARY KEY(key_id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
    ```

=== "PostgreSQL"

    ```sql
    -- ibexa/messenger
    CREATE TABLE IF NOT EXISTS ibexa_messenger_messages (
        id BIGSERIAL NOT NULL,
        body TEXT NOT NULL,
        headers TEXT NOT NULL,
        queue_name VARCHAR(190) NOT NULL,
        created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
        available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
        delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
        PRIMARY KEY(id)
    );

    CREATE INDEX IF NOT EXISTS ibexa_messenger_created_at_idx ON ibexa_messenger_messages (created_at);
    CREATE INDEX IF NOT EXISTS ibexa_messenger_available_at_idx ON ibexa_messenger_messages (available_at);
    CREATE INDEX IF NOT EXISTS ibexa_messenger_delivered_at_idx ON ibexa_messenger_messages (delivered_at);
    COMMENT ON COLUMN ibexa_messenger_messages.created_at IS '(DC2Type:datetime_immutable)';
    COMMENT ON COLUMN ibexa_messenger_messages.available_at IS '(DC2Type:datetime_immutable)';
    COMMENT ON COLUMN ibexa_messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)';

    CREATE TABLE IF NOT EXISTS ibexa_messenger_lock_keys (
        key_id VARCHAR(64) NOT NULL,
        key_token VARCHAR(44) NOT NULL,
        key_expiration INT NOT NULL,
        PRIMARY KEY(key_id)
    );
    ```

## How it works

[[= product_name_base =]] Messenger uses a command bus as a queue that stores messages, or commands, which tell the system what you want to happen, and separates them from the handler, which is the code that actually performs the task.

The process works as follows:

1. A message PHP object is dispatched, for example, `ProductPriceReindex`.
2. The message is wrapped in an envelope, which may contain additional metadata, called stamps, for example, `DeduplicateStamp`.
3. The message is placed in the transport queue.
It can be a Doctrine table, a Redis/Valkey queue, and so on.
4. A worker process continuously reads messages from the queue, pulls them into the default bus `ibexa.messenger.bus` and assigns them to the right handler.
5. A handler service processes the message (executes the command).
You can register multiple handlers for different jobs.

Here is an example of how you can extend your code and use [[= product_name_base =]] Messenger to process your tasks:

### Configure package

Create a config file, for example, `config/packages/ibexa_messenger.yaml` and define your transport:

``` yaml
ibexa_messenger:

    # The DSN of the transport, as expected by Symfony Messenger transport factory.
    transport_dsn:        'doctrine://default?table_name=ibexa_messenger_messages&auto_setup=false'
    deduplication_lock_storage:
        enabled:              true

        # Doctrine DBAL primary connection or custom service
        type:                 doctrine # One of "doctrine"; "custom"; "service"

        # The service ID of a custom Lock Store, if "service" type is selected
        service:              null

        # The DSN of the lock store, if "custom" type is selected
        dsn:                  null
```

!!! note "Supported transports"

    You can define different transports: [[= product_name_base =]] Messenger has been tested to work with Redis, MySQL, PostgreSQL.
    For more information, see [Symfony Messenger documentation](https://symfony.com/doc/current/messenger.html#transports-async-queued-messages) or [Symfony Messenger tutorial](https://symfonycasts.com/screencast/messenger/install#installing-messenger).

### Start worker

Use a process manager of your choice to run the following command, or make it start together with the server:

``` bash
php bin/console messenger:consume ibexa.messenger.transport --bus=ibexa.messenger.bus --siteaccess=<OPTIONAL>`
```

In [multi-repository setups](repository_configuration.md), the worker process always works for a [SiteAccess](multisite_configuration.md#siteaccess-configuration) that you indicate by using the `--siteaccess` option, therefore you may need to run multiple workers, one for each SiteAccess.

!!! warning "Multi-repository setups"

    Doctrine transport works across multiple repositories without issues, but other transports may need to be adjusted, so that queues across different repositories are not accidentally shared.

!!! note "Deploying [[= product_name_base =]] Messenger"

    Additional considerations regarding the deployment of Symfony Messenger to production, which you can find in [Symfony documentation](https://symfony.com/doc/current/messenger.html#deploying-to-production) apply to [[= product_name_base =]] Messenger as well.

### Dispatch message

Dispatch a message from your code like in the following example:

``` php
[[= include_file("code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php") =]]
```

### Register handler

Create the handler class:

``` php
[[= include_file("code_samples/background_tasks/src/MessageHandler/SomeHandler.php") =]]
```

Add a service definition to `config/services.yaml`:

``` yaml
services:
    App\MessageHandler\SomeHandler:
        tags:
            - name: messenger.message_handler
              bus: ibexa.messenger.bus
```
