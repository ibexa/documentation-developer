---
description: Twig functions exposed by Quable connector
page_type: reference
---

# Quable Twig functions

The [Quable connector](quable.md) provides the following Twig functions:

## `ibexa_quable_instance_url()`

Returns the [configured Quable instance URL](configure_quable_connector.md#configuration-example) (`ibexa_connector_quable.instance_url`).

### Example

``` html+twig
<a
    href="{{ ibexa_quable_instance_url() }}/#classification"
    target="_blank"
    rel="noopener noreferrer"
>
    Manage in Quable
</a>
```
