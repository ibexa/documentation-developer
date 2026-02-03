---
description: CDP Monolog channel
edition: experience
---

# CDP Monolog channel

CDP Monolog channel handles webhook logs for easier separation of logs.

```bash
- { name: monolog.logger, channel: ibexa.cdp.webhook }
```

It's possible to configure `ibexa.cdp.webhook` Monolog channel to direct all logs to specific stream, file, or service.
This allows webhook logs to be stored separately from the main application logs for easier debugging and analysis.

To do it, in `config/packages/monolog.yaml` file, define a new handler for the `ibexa.cdp.webhook` channel that directs CPD Webhook events to a separate file.
it can be configured in both `dev` and `prod` environments, for example:

=== "Dev"

    ```yaml
    when@dev:
    monolog:
        handlers:
            cdp_webhook:
                type: stream
                path: "%kernel.logs_dir%/cdp_webhook_%kernel.environment%.log"
                level: debug
                channels: [ 'ibexa.cdp.webhook' ]
    ```

=== "Prod"

    ```yaml
    when@prod:
    monolog:
        handlers:
            cdp_webhook:
                type: stream
                path: "%kernel.logs_dir%/cdp_webhook_%kernel.environment%.log"
                level: debug
                channels: [ 'ibexa.cdp.webhook' ]
    ```

If you want to avoid redundant or duplicate entries in the other log, exclude the webhook channel by:

```yaml
channels: ["!ibexa.cdp.webhook"]
```
