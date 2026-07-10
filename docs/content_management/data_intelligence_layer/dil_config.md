---
description: TODO.
month_change: true
---

# Data Intelligence Layer configuration

## Background tasks

Metric data are computed as a [background task using Ibexa Messenger](background_tasks.md).

- `ibexa.data_intelligence_layer.freshness.default_interval_days`: Number of days between computation of the metrics - default is 90 days
- `ibexa.data_intelligence_layer.freshness.content_type_intervals`: Custom number of days per content type - default is empty

```yaml
parameters:
    ibexa.data_intelligence_layer.freshness.default_interval_days: 30 # Increase frequency to every 30 days for all content types
    ibexa.data_intelligence_layer.freshness.content_type_intervals: # Map content type identifier to custom interval in days
        article: 15 # Compute metrics for articles every 15 days
```

## MCP server configuration

The MCP server `data_intelligence_layer` is already configured for the path `/mcp/data-intelligence`.
It's enabled by default but not assigned to any SiteAccess.
Assign it to the `admin_group`:

```yaml
ibexa:
    system:
        admin_group:
            mcp:
                servers:
                    - data_intelligence_layer
```
