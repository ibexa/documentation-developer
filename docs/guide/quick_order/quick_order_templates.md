# Quick order templates

### Template list

| Path     | Description       |
| -------- | ----------------- |
| `Siso/Bundle/QuickOrderBundle/Resources/views/QuickOrder/quick_order.html.twig`       | Entry page for the quick order.   |
| `Siso/Bundle/QuickOrderBundle/Resources/views/QuickOrder/quick_order_form.html.twig` | Renders the content of the quick order page.      |
| `Siso/Bundle/QuickOrderBundle/Resources/views/QuickOrder/quick_order_line.html.twig` | Renders the content of one quick order line. This template is used to replace the quick order line after creating the line preview. |

### Related routes

``` yaml
siso_quick_order:
    pattern: /quickorder
        defaults: { _controller: SisoQuickOrderBundle:QuickOrder:quickOrder }
```
