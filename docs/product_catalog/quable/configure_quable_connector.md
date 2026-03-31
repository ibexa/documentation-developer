---
description: Quable PIM connector configuration reference for Ibexa DXP
page_type: reference
---

# Configure Quable connector

This page provides a complete reference for configuring the [[= pim_product_name =]] PIM connector in [[= product_name =]].

Use the `ibexa_connector_quable` key in `config/packages/ibexa_connector_quable.yaml` to customize [[= pim_product_name =]] behavior.

## Configuration example

``` yaml
ibexa_connector_quable:
    enabled: true
    instance_url: 'https://example.quable.com'
    api_token: '<your_api_token>'
    channel_code: '<channel_code>'
    webhook_secret: '<webhook authorization header>' # Needed for webhook authentication
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

| Parameter | Default value | Description |
|-----------|--------------------------|-------------|
| `enabled` | `false` | Enables the connector bundle configuration. |
| `instance_url` | string | Base URL of your [[= pim_product_name =]] instance, for example `https://example.quable.com`. |
| `api_token` | string | Read Access API token used to authenticate requests to [[= pim_product_name =]]. |
| `channel_code` | string | Code of the [[= pim_product_name =]] channel used as the source of product data. |
| `webhook_secret` | string | Secret expected in the webhook authorization header. |
| `throw_on_invalid_criteria` | `%kernel.debug%` | Controls behavior for unsupported filter/search criteria: `true` throws an exception, `false` ignores unsupported criteria. |
| `throw_on_invalid_mapping` | `%kernel.debug%` | Controls behavior for mapping errors during data transformation: `true` throws an exception, `false` ignores mapping errors. |
| `cache.enabled` | `true` | Global cache switch for the connector. When `false`, cache decorators use only [in-memory cache](persistence_cache.md#in-memory-cache-configuration). |
| `cache.attribute` | `true` | Enables caching for attribute definition requests. |
| `cache.attribute_group` | `true` | Enables caching for attribute group requests. |
| `cache.product` | `true` | Enables caching for product requests. |
| `cache.product_type` | `true` | Enables caching for product type requests. |

In production environments, it's recommended to:

- enable caching for better performance, using Redis or Valkey as [persistence cache](persistence_cache.md#redisvalkey)
- disable `throw_on_invalid_criteria` and `throw_on_invalid_mapping` to prevent non-critical errors from causing application crashes
