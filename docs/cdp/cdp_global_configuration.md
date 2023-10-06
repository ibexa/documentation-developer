---
description: Global configuration of Ibexa CDP.
---

# CDP global configuration

## Configuration key

Global configuration in Ibexa CDP allows you to automate the process of exporting Content, Users and Products.
Global `ibexa_cdp` [configuration key](configuration.md#configuration-files) looks as below:

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

Under `schedule` setting you can find separate sections for exporting User, Content, and Product. 
Structure of each section is exactly the same and includes `interval` and `options` elements:

- **Interval** - sets the frequency of the command invoke, for example, '*/30 * * * *' - every 30 minutes, '0 */12 * * *' - every 12 hours. 
It uses standard `crontab` format (see: https://crontab.guru/examples.html).
- **Options** - allows you to add arguments that have to be passed to the export command.

This configuration allows you to provide multiple export tools with parameters. It's important, because each type of content/product must have its own parameters on the CDP website, where each has a different Stream ID key and different required values, for example, `--content-type`.

Accepted options can be listed with this command:

```bash
php bin/console ibexa:cdp:stream-user-data --help
```