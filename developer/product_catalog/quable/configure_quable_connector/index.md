# Configure Quable connector

Quable PIM connector configuration reference for Ibexa DXP

You can customize the behavior of the Quable integration add-on by using the following [configuration](../../../administration/configuration/configuration/index.md).

## Configuration example

In `config/packages/ibexa_connector_quable.yaml`, specify your configuration by using the `ibexa_connector_quable` key:

```yaml
ibexa_connector_quable:
    enabled: true
    instance_url: 'https://example.quable.com'
    api_token: '<your_api_token>'
    channel_code: '<channel_code>'
    webhook_secret: '<webhook authorization header>' # Needed for webhook authentication
    language_map:
        eng-GB: en_GB
        fre-FR: fr_FR
    throw_on_invalid_criteria: '%kernel.debug%'
    throw_on_invalid_mapping: '%kernel.debug%'
    cache:
        enabled: true
        attribute: true
        attribute_group: true
        product: true
        product_type: true
```

## Configuration options

| Parameter                   | Default value    | Description                                                                                                                                                                                                                                                                                                                                               |
| --------------------------- | ---------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `enabled`                   | `false`          | Enables the connector.                                                                                                                                                                                                                                                                                                                                    |
| `instance_url`              | string           | Base URL of your Quable instance, for example `https://example.quable.com`.                                                                                                                                                                                                                                                                               |
| `api_token`                 | string           | [Read Access API token](https://docs.quable.com/v5-EN/docs/api-tokens) used to authenticate requests to Quable.                                                                                                                                                                                                                                           |
| `channel_code`              | string           | Code of the [Quable channel](https://docs.quable.com/v5-EN/docs/content-channels) used as the source of product data.                                                                                                                                                                                                                                     |
| `webhook_secret`            | string           | Secret expected in the [webhook](https://docs.quable.com/v5-EN/docs/webhook) authorization header.                                                                                                                                                                                                                                                        |
| `language_map`              | Empty            | Maps Ibexa DXP language codes (for example, `eng-GB`) to Quable locale codes (for example, `en_GB`). For more information, see [Set up Quable languages](../install_quable/index.md#set-up-languages).                                                                                                            |
| `throw_on_invalid_criteria` | `%kernel.debug%` | Controls behavior for unsupported search criteria: `true` throws an exception, `false` only logs unsupported criteria.                                                                                                                                                                                                                                    |
| `throw_on_invalid_mapping`  | `%kernel.debug%` | Controls behavior for mapping errors during data transformation: `true` throws an exception, `false` only logs mapping errors.                                                                                                                                                                                                                            |
| `cache.enabled`             | `true`           | Global cache switch for the connector. When set to `false`, only [in-memory cache](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#in-memory-cache-configuration) is used. When set to `true`, [Symfony's `cache.app` cache pool](https://symfony.com/doc/7.4/cache.html#system-cache-and-application-cache) is used. |
| `cache.attribute`           | `true`           | Enables caching for attribute definition requests.                                                                                                                                                                                                                                                                                                        |
| `cache.` `attribute_group`  | `true`           | Enables caching for attribute group requests.                                                                                                                                                                                                                                                                                                             |
| `cache.` `product`          | `true`           | Enables caching for product requests.                                                                                                                                                                                                                                                                                                                     |
| `cache.` `product_type`     | `true`           | Enables caching for product type requests.                                                                                                                                                                                                                                                                                                                |

In production environments, it's recommended to:

- keep the `api_token` and the `webhook_secret` [secure](../../../infrastructure_and_maintenance/security/security_checklist/index.md#app_secret-and-other-secrets)
- enable caching for better performance, by using Redis or Valkey as [persistence cache](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#redisvalkey)
- disable `throw_on_invalid_criteria` and `throw_on_invalid_mapping` to prevent non-critical errors from causing application crashes
