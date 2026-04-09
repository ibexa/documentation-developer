---
description: Twig functions exposed by Quable connector
page_type: reference
month_change: true
---

# Quable Twig functions

The [[[= pim_product_name =]] connector](/product_catalog/quable/quable.md) provides the following Twig functions:

## `ibexa_quable_instance_url()`

Returns the [configured [[= pim_product_name =]] instance URL](/product_catalog/quable/configure_quable_connector.md#configuration-example), value of the `ibexa_connector_quable.instance_url` parameter.
You can use it to inject a link to [[= pim_product_name =]]'s back office into [[= product_name =]]'s back office, improving the experience for your editors.

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
