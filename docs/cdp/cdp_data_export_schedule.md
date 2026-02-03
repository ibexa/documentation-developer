---
description: Data export schedule in Ibexa CDP.
edition: experience
---

# CDP data export schedule

## Configuration key

Configuration in [[= product_name_cdp =]] allows you to automate the process of exporting content, users, and products.
An `ibexa_cdp.data_export` [configuration key](configuration.md#configuration-files) looks as below:

```yaml
ibexa_cdp:
    data_export:
        schedule:
            user:
                -
                    interval: '*/15 * * * *'
                    options: '--stream-id=00000000-00000000-00000000-00000000 --user-content-type=user --no-draft'
                -
                    interval: '0 */6 * * *'
                    options: '--stream-id=00000000-00000000-00000000-00000000 --user-content-type=user --no-draft'
            content:
                -
                    interval: '*/30 * * * *'
                    options: '--stream-id=00000000-00000000-00000000-00000000 --content-type=article --no-draft'
                -
                    interval: '0 */12 * * *'
                    options: '--stream-id=00000000-00000000-00000000-00000000 --content-type=article --no-draft'
            product:
                -
                    interval: '*/30 * * * *'
                    options: '--stream-id=00000000-00000000-00000000-00000000 --product-type=computer --no-draft'
                -
                    interval: '0 */12 * * *'
                    options: '--stream-id=00000000-00000000-00000000-00000000 --product-type=computer --no-draft'
```

Under the `schedule` setting you can find separate sections for exporting user, content, and product.
Structure of each section is exactly the same and includes `interval` and `options` elements:

- `interval` - sets the frequency of the command invoke, for example, '*/30 * * * *' means "every 30 minutes", '0 */12 * * *' means "every 12th hour".
It uses a standard `crontab` format, see [examples](https://crontab.guru/examples.html).
- `options`- allows you to add arguments that have to be passed to the export command.

This configuration allows you to provide multiple export workflows with parameters.
It's important, because each type of content/product must have its own parameters on the CDP side, where each has a different Stream ID key and different required values, which are configured per data source.

Accepted options can be listed with the command below:

* for User:

```bash
php bin/console ibexa:cdp:stream-user-data --help
```

* for Product:

```bash
php bin/console ibexa:cdp:stream-product-data --help
```

* for Content:

```bash
php bin/console ibexa:cdp:stream-content-data --help
```

## [[= product_name_base =]] Messenger support for large batches of data

CDP uses [[= product_name_base =]] Messenger to process data.
This approach improves performance and reliability when processing large amounts of CDP user records.
For more information, see [Background tasks: How it works](background_tasks.md#how-it-works).

By using Messenger while working with large batches of data, requests are queued instead of being processed synchronously:

- queuing items starts automatically once a certain number of actions is reached (below this number, items are processed in a single request, using the standard synchronous behavior)
- every single data is recorded in the database
- a background worker retrieves records from the queue, processing them one by one or in batches, depending on the [Messenger](https://symfony.com/doc/current/messenger.html) configuration
- processing happens at set intervals to avoid timeouts and keep the system stable

Messenger requires a dedicated database table.
This table is not created automatically and must be added manually using a database update script.

Follow the [database update procedure](https://doc.ibexa.co/en/latest/update_and_migration/from_5.0/update_from_5.0/#database-update) to proceed.

1\. Make sure that the transport layer is [defined properly](background_tasks.md#configure-package) in [[= product_name_base =]] Messenger configuration.

2\. Add `bulk_async_threshold` setting in the `config/packages/ibexa_cdp.yaml` configuration:

``` bash
ibexa_cdp:
      bulk_async_threshold: 100  # Default: 100 items
```

Available options:

- `bulk_async_threshold` (integer, default: 100) - minimum number of items required to trigger asynchronous processing
    - below threshold - items are processed immediately in a single request, using the standard synchronous behavior
    - at/above threshold - items are automatically dispatched to the asynchronous queue for background processing

3\. Make sure that the [worker starts](background_tasks.md#start-worker) together with the application to watch the transport bus:

``` bash
php bin/console messenger:consume ibexa.messenger.transport --bus=ibexa.messenger.bus
```

!!! note "Deploying Symfony Messenger"

    For more information about deploying the Messenger to production, see [Symfony documentation]([[= symfony_doc =]]/messenger.html#deploying-to-production).
