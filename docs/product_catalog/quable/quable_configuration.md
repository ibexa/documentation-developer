---
description: Quable PIM connector configuration reference for Ibexa DXP
---

# Quable configuration reference

This page provides a complete reference for configuring the Quable PIM connector in [[= product_name =]].

## Connector configuration

The Quable connector is configured in a YAML file in the `config/packages` directory, typically named `ibexa_connector_quable.yaml`.

### Basic configuration

``` yaml
ibexa_connector_quable:
    instance_url: 'https://your-instance.quable.com'
    api_token: '%env(QUABLE_API_TOKEN)%'
    webhook_secret: '%env(QUABLE_WEBHOOK_SECRET)%'
    cache:
        enabled: true
```

### Configuration parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `instance_url` | string | Yes | The URL of your Quable PIM instance (e.g., `https://example.quable.com`) |
| `api_token` | string | Yes | API authentication token from Quable. Use environment variables for security. |
| `webhook_secret` | string | No | Secret key for validating webhook requests from Quable. Required if using real-time synchronization. |
| `cache.enabled` | boolean | No | Enable or disable caching of Quable data. Default: `true`. Recommended for production. |

!!! tip "Environment variables"

    Store sensitive configuration values like API tokens in environment variables or `.env` files:
    
    ```
    QUABLE_API_TOKEN=your_read_access_token_here
    QUABLE_WEBHOOK_SECRET=your_webhook_secret_here
    ```

## Product Catalog engine configuration

Configure [[= product_name =]]'s Product Catalog to use Quable as the data source in `config/packages/ibexa_product_catalog.yaml`.

### Engine definition

``` yaml
ibexa_product_catalog:
    engines:
        local:
            type: local
            options:
                root_location_remote_id: ibexa_product_catalog_root
                product_type_group_identifier: product
        quable:
            type: quable
            options:
                taxonomy: quable
                root_location_remote_id: ibexa_product_catalog_root
                product_type_group_identifier: product
```

### Engine options

| Option | Description | Default |
|--------|-------------|---------|
| `taxonomy` | Taxonomy identifier for Quable classifications | `quable` |
| `root_location_remote_id` | Remote ID of the root location for product catalog | `ibexa_product_catalog_root` |
| `product_type_group_identifier` | Identifier for the product type group | `product` |

### Repository configuration

Set the Quable engine as the default for your repository in `config/packages/ibexa.yaml`:

``` yaml
ibexa:
    repositories:
        default:
            storage: ~
            search:
                engine: '%search_engine%'
                connection: default
            product_catalog:
                engine: quable
                regions:
                    default: ~
```

## Cache configuration

The Quable connector implements caching to reduce API calls and improve performance.

### Cache settings

``` yaml
ibexa_connector_quable:
    instance_url: 'https://your-instance.quable.com'
    api_token: '%env(QUABLE_API_TOKEN)%'
    cache:
        enabled: true
```

### Cache behavior

When caching is enabled:

- Product data is cached after the first request
- Subsequent requests use cached data instead of calling Quable API
- Cache is automatically invalidated when webhooks receive update notifications
- Manual cache clearing: `php bin/console cache:clear`

!!! note "Production recommendation"

    Always enable caching in production environments to minimize API calls and improve response times. Cache invalidation is handled automatically via webhooks.

## Language alignment

[[= product_name =]] and Quable must have matching language configurations for proper data synchronization.

### Language configuration requirements

Ensure that:

1. All languages enabled in [[= product_name =]] exist in Quable PIM
2. Language codes match between systems (e.g., `eng-GB`, `fre-FR`)
3. Default language is consistent across both systems

### Example language configuration

In [[= product_name =]] (`config/packages/ibexa.yaml`):

``` yaml
ibexa:
    system:
        default:
            languages:
                - eng-GB
                - fre-FR
                - ger-DE
```

Verify these language codes exist in your Quable PIM instance.

!!! warning "Mismatched languages"

    If languages don't match between systems, product translations may not display correctly or may be missing entirely.

## Channel selection

For multi-channel Quable setups, you can configure which channel's data to display in [[= product_name =]].

!!! note "Channel configuration"

    Channel selection configuration varies by deployment. Consult Ibexa support for channel-specific configuration options.

## Synchronization configuration

### Taxonomy synchronization

Taxonomy (classification) synchronization is triggered manually via console command:

``` bash
php bin/console ibexa:quable:classification:sync
```

**Command options:**

- `-vv` - Verbose output showing detailed API requests
- Add to cron for periodic synchronization if not using webhooks

### Real-time synchronization

Real-time synchronization uses webhooks configured in Quable PIM. When enabled, product data updates automatically when changes occur in Quable.

**Webhook configuration:**

``` yaml
ibexa_connector_quable:
    instance_url: 'https://your-instance.quable.com'
    api_token: '%env(QUABLE_API_TOKEN)%'
    webhook_secret: '%env(QUABLE_WEBHOOK_SECRET)%'
```

The `webhook_secret` validates incoming webhook requests to ensure they originate from your Quable instance.

### What synchronizes

| Data Type | Synchronization Method | Notes |
|-----------|----------------------|-------|
| Products | Real-time (webhooks) or API calls | Product details, attributes, variants |
| Product Types | Real-time (webhooks) or API calls | Type definitions and attribute schemas |
| Attributes | Real-time (webhooks) or API calls | Attribute definitions and values |
| Classifications/Categories | Manual command or webhooks | Hierarchical category structure |
| Assets | On-demand | Images, videos, documents linked to products |

### What doesn't synchronize

The following data remains independent in each system:

- [[= product_name =]] content items and content types
- User accounts and permissions
- Site configurations
- Custom prices set in [[= product_name =]] (override Quable prices)
- Local product catalogs

## Performance optimization

### Optimize API calls

1. **Enable caching** - Reduces repeated API calls
2. **Use webhooks** - Avoid polling for updates
3. **Limit verbose logging** - Use `-vv` only for debugging

### Connection pooling

The Quable connector uses Symfony's HTTP client with connection pooling enabled by default for optimal performance.

## Environment-specific configuration

### Development environment

``` yaml
# config/packages/dev/ibexa_connector_quable.yaml
ibexa_connector_quable:
    instance_url: 'https://example.quable.com'
    api_token: '%env(QUABLE_API_TOKEN)%'
    cache:
        enabled: false  # Disable for development to always fetch fresh data
```

### Production environment

``` yaml
# config/packages/prod/ibexa_connector_quable.yaml
ibexa_connector_quable:
    instance_url: 'https://production.quable.com'
    api_token: '%env(QUABLE_API_TOKEN)%'
    webhook_secret: '%env(QUABLE_WEBHOOK_SECRET)%'
    cache:
        enabled: true  # Always enable in production
```
