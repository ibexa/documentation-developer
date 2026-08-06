# Quable Twig functions

Twig functions exposed by the Quable connector.

The [Quable connector](../../../product_catalog/quable/quable/index.md) provides the following Twig functions:

## `ibexa_quable_instance_url()`

Returns the [configured Quable instance URL](../../../product_catalog/quable/configure_quable_connector/index.md#configuration-example), value of the `ibexa_connector_quable.instance_url` parameter. You can use it to inject a link to the Quable's back office into Ibexa DXP's back office, to improve the experience for your editors.

### Example

```html+twig
<a
    href="{{ ibexa_quable_instance_url() }}/#classification"
    target="_blank"
    rel="noopener noreferrer"
>
    Manage in Quable
</a>
```
