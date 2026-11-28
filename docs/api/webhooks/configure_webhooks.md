---
description: Install and configure webhooks, including the signing secret encryption key, the delivery transport, retries, and delivery log retention.
month_change: false
---

# Configure webhooks

Webhooks are provided by the `ibexa/webhooks` package.
The package requires the `ibexa/rest` and `ibexa/messenger` packages, which are part of every [[= product_name =]] edition.
The back office screens additionally require `ibexa/admin-ui`.

## Installation

### Install package

Run the following command to install the package:

``` bash
composer require ibexa/webhooks
```

### Modify the bundles file

Then, if not using Symfony Flex, add the following code to the `config/bundles.php` file:

``` php
<?php

return [
    // A lot of bundles…
    Ibexa\Bundle\Webhooks\IbexaWebhooksBundle::class => ['all' => true],
];
```

Make sure that `Ibexa\Bundle\Messenger\IbexaMessengerBundle` is registered as well.

### Import routes

Create the `config/routes/ibexa_webhooks.yaml` file with the following content, to register the back office screens and the REST API endpoints:

``` yaml
ibexa.webhooks:
    resource: '@IbexaWebhooksBundle/Resources/config/routing.yaml'

ibexa.webhooks.rest:
    resource: '@IbexaWebhooksBundle/Resources/config/routing_rest.yaml'
    prefix: '%ibexa.rest.path_prefix%'
```

### Add tables to the database

Webhooks store their configuration in the `ibexa_webhook` table and the delivery log in the `ibexa_webhook_delivery` table.
Both tables are defined in the [[= product_name =]] database schema, so they're created when you install a new project.

To add them to an existing database, generate the SQL statements for your database engine and run them:

``` bash
php bin/console ibexa:doctrine:schema:dump-sql
```

### Generate encryption key

Signing secrets of webhooks are encrypted in the database with a key that you must provide.
The key must be exactly 32 bytes long.

Generate a key and store it, base64-encoded, in an environment variable, for example, in the `.env.local` file:

``` bash
php -r 'echo base64_encode(sodium_crypto_secretbox_keygen()), PHP_EOL;'
```

``` bash
WEBHOOK_SECRET_KEY=<generated_key>
```

Then, reference the variable in the `config/packages/ibexa_webhooks.yaml` file:

``` yaml
ibexa_webhooks:
    secret_key: '%env(base64:WEBHOOK_SECRET_KEY)%'
```

!!! caution "Keep the encryption key safe"

    Treat the encryption key like any other credential: don't commit it to the repository and use the same key in every environment that shares the database.
    If you lose or change the key, the stored signing secrets can't be decrypted, and deliveries fail until you regenerate the signing secret of every webhook.

## Configure delivery

### Delivery transport

Deliveries are dispatched on the `ibexa.messenger.bus` message bus and always routed to a dedicated `ibexa_webhook` transport, registered by the package.
The routing doesn't depend on the `framework.messenger.routing` configuration of your application.

By default, the transport uses the `sync://` DSN, which sends webhooks immediately, within the request that triggered the event.
This setting is convenient for development, but it makes editors wait for the receiving systems to respond, and failed deliveries aren't retried.

For production, set the `delivery.transport_dsn` setting to an asynchronous DSN supported by one of the installed [Symfony Messenger transports](https://symfony.com/doc/current/messenger.html#transports-async-queued-messages).
For example, to use a dedicated queue in the database table used by `ibexa/messenger`:

``` yaml
ibexa_webhooks:
    delivery:
        transport_dsn: 'doctrine://ibexa.current?table_name=ibexa_messenger_messages&queue_name=ibexa_webhook&auto_setup=false'
```

To use an external message broker, reference its DSN through an environment variable:

``` yaml
ibexa_webhooks:
    delivery:
        transport_dsn: '%env(WEBHOOK_TRANSPORT_DSN)%'
```

``` bash
WEBHOOK_TRANSPORT_DSN=amqp://guest:guest@rabbitmq:5672/%2f/ibexa_webhook
```

### Run the worker

With an asynchronous transport, deliveries are sent by a worker process that consumes the `ibexa_webhook` transport:

``` bash
php bin/console messenger:consume ibexa_webhook --time-limit=3600
```

In production, run the worker under a process manager, such as Supervisor or systemd, which restarts it when it stops.
For more information, see [Deploying to production](https://symfony.com/doc/current/messenger.html#deploying-to-production) in Symfony documentation.

### Timeouts and retries

A delivery fails when the receiver can't be reached, doesn't respond in time, or responds with a status code other than `2xx`.

A failed delivery is retried up to `delivery.max_retries` times.
The first retry happens after 1 second, and every next delay is three times longer than the previous one (1, 3, 9 seconds, and so on).
When all retries are exhausted, the delivery remains in the delivery log with the `failed` status.

!!! note "Failure transport"

    The `ibexa_webhook` transport isn't declared under `framework.messenger`, so the `framework.messenger.failure_transport` setting doesn't apply to it.
    Failed deliveries are kept in the delivery log instead, from where you can [re-send them](webhooks_api.md#re-send-deliveries).

### Automatic disabling

Every failed attempt, including retries and test deliveries, increases the consecutive failure counter of the webhook, and every successful delivery resets it.
When the counter reaches `delivery.auto_disable_after`, the webhook is disabled, and its owner receives a back office notification.

With the default settings, one event that can't be delivered produces four failed attempts (the first attempt and three retries).
Adjust `delivery.auto_disable_after` and `delivery.max_retries` together to match the expected availability of the receiving systems.

## Delivery log retention

Delivery log entries older than `retention.delivery_log_days` days are removed by the following command:

``` bash
php bin/console ibexa:webhooks:prune-delivery-log
```

If the `ibexa/cron` package is installed, the command runs automatically every day at 03:00.
Otherwise, schedule it with the task scheduler of your system.

## Configuration reference

All settings are placed under the `ibexa_webhooks` [configuration key](configuration.md#configuration-files).
Only `secret_key` is required.
The example below shows the default values of all other settings:

``` yaml
ibexa_webhooks:
    secret_key: '%env(base64:WEBHOOK_SECRET_KEY)%'
    delivery:
        transport_dsn: 'sync://'
        timeout:
            connect: 5
            response: 10
        max_retries: 3
        auto_disable_after: 10
    retention:
        delivery_log_days: 30
    signature:
        header: 'X-Cohesivo-Signature'
        algo: 'sha256'
```

The following settings are available:

| Setting | Default value | Description |
|---|---|---|
| `secret_key` | | Raw, 32-byte key used to encrypt signing secrets in the database. Required. |
| `delivery.transport_dsn` | `sync://` | Symfony Messenger DSN of the `ibexa_webhook` transport. Use an asynchronous DSN in production. |
| `delivery.timeout.connect` | `5` | Time, in seconds, to wait for the receiver to accept the connection. |
| `delivery.timeout.response` | `10` | Maximum total duration of a request, in seconds. |
| `delivery.max_retries` | `3` | Number of retries before a delivery is considered failed. Set to `0` to disable retries. |
| `delivery.auto_disable_after` | `10` | Number of consecutive failed attempts after which a webhook is disabled automatically. |
| `retention.delivery_log_days` | `30` | Number of days for which delivery log entries are kept. |
| `signature.header` | `X-Cohesivo-Signature` | Name of the HTTP header that carries the signature. |
| `signature.algo` | `sha256` | Hashing algorithm used to compute the HMAC signature. Accepts any algorithm supported by the PHP [`hash_hmac()`](https://www.php.net/manual/en/function.hash-hmac.php) function. |

## Permissions

To work with webhooks, users need the [`webhook` policies](permissions/policies.md#webhooks):

| Function | Grants access to |
|---|---|
| `webhook/read` | the **Webhooks** item in the **Admin** menu, the webhook list, the delivery log, and the list of event types |
| `webhook/create` | creating webhooks |
| `webhook/update` | editing, enabling, and disabling webhooks, regenerating signing secrets, and re-sending deliveries |
| `webhook/delete` | removing webhooks together with their delivery log |
| `webhook/test` | sending test deliveries |

Because webhooks can send repository data to any URL, grant these policies, especially `webhook/create` and `webhook/update`, only to trusted administrators.
