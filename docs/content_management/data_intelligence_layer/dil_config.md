---
description: TODO.
month_change: true
---

# Data Intelligence Layer configuration

## Install

TODO: How is it packaged? Is it installed within regular edition?

```bash
composer require ibexa/data-intelligence-layer
php bin/console doctrine:query:sql "$(php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/data-intelligence-layer/src/bundle/Resources/config/schema.yaml)"
```

## Background tasks

Metric data are computed as a [background task using Ibexa Messenger](background_tasks.md), so, make sure it's running.

You can set the interval between computations of metrics with the following parameters:

- `ibexa.data_intelligence_layer.freshness.default_interval_days`: Number of days between computation of the metrics - default is 90 days
- `ibexa.data_intelligence_layer.freshness.content_type_intervals`: Custom number of days per content type - default is empty

```yaml
parameters:
    ibexa.data_intelligence_layer.freshness.default_interval_days: 30 # Increase frequency to every 30 days for all content types
    ibexa.data_intelligence_layer.freshness.content_type_intervals: # Map content type identifier to custom interval in days
        article: 15 # Compute metrics for articles every 15 days
```

## MCP server configuration

The MCP server `data_intelligence_layer` is already configured for the path `/mcp/data-intelligence` and is enabled by default.
It needs

- to be associated to some SiteAccesses
- to be allowed to be accessed from other hosts than `localhost`, `127.0.0.1`, and `[::1]`
- to have discovery cache enabled in production (by default, it's disabled for development)
- to have another session storage than the default `public/var/` directory

For example, assign it to the `admin_group`, allow your production admin domain and development domains, use the default cache pool for discovery cache and sessions:

```yaml
[[= include_code('code_samples/mcp/config/packages/mcp.dil.yaml') =]]
```
