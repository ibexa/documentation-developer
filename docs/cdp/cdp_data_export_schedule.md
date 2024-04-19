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
