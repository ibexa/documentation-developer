# Customize product attribute templates

Customize the Twig templates used to render product attribute values.

The `ibexa_format_product_attribute` Twig filter renders a product attribute value by using a configurable list of Twig templates. Each template contains Twig blocks that control how specific [attribute types](../products/index.md#product-attributes) are displayed.

You can customize this rendering by:

- adding your own template [to the configuration](../product_catalog_configuration/index.md#attribute-rendering-templates).
- injecting a template by subscribing to the [`ProductAttributeRenderEvent`](../../api/event_reference/product_catalog_events/index.md#attribute-rendering) event

## Template blocks

Each template can define the following blocks:

| Block                         | Used for                                                                                                                                                         |
| ----------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `<type_identifier>_attribute` | Rendering an attribute of a specific type. Replace `<type_identifier>` with the attribute type identifier, for example `color_attribute` or `integer_attribute`. |
| `generic_attribute`           | Fallback block used when no type-specific block is found.                                                                                                        |

For a list of available attributes, see [product attributes](../products/index.md#product-attributes).

When rendering an attribute, the system iterates through the configured templates in order and uses the first matching type-specific block it finds. If none is found, it falls back to the first `generic_attribute` block available.

### Quable attribute types

When using [Quable PIM](../quable/quable/index.md), use the following identifiers to override the templates for [Quable's attribute types](https://docs.quable.com/v5-EN/docs/objects-and-attributes#attribute-types):

| Attribute name                       | Identifier         |
| ------------------------------------ | ------------------ |
| Simple text not localized            | `unlocalized_text` |
| Simple text localized                | `localized_text`   |
| Text area localized                  | `multiline_text`   |
| HTML code                            | `html_text`        |
| JSON code                            | `json_text`        |
| Integer                              | `integer`          |
| Decimal                              | `decimal`          |
| Date                                 | `date`             |
| Time                                 | `time`             |
| Checkbox                             | `switch`           |
| Simple select of predefined values   | `simple_select`    |
| Select of multiple predefined values | `multi_select`     |
| Calculated                           | `calculated`       |

### Template variables

The following variables are available in attribute template blocks:

| Variable     | Type                                                                                                                                                    | Description                                                                            |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------- |
| `attribute`  | [`Ibexa\Contracts\ProductCatalog\Values\AttributeInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/AttributeInterface.php) | The attribute object being rendered.                                                   |
| `value`      | `?string`                                                                                                                                               | The pre-formatted attribute value, produced by the value formatter.                    |
| `parameters` | `array`                                                                                                                                                 | Optional rendering parameters passed to the filter or modified by an event subscriber. |

## Create custom attribute template

Create a Twig template and define the blocks for the attribute types you want to customize:

- To customize a specific attribute type, define a block named `<type_identifier>_attribute`.
- To handle all remaining types, define a `generic_attribute` block.

The following example adds a custom template for an `integer` attribute type:

```html+twig
{# templates/product/attributes/integer_attribute.html.twig #}

{% block integer_attribute %}
    Integer value: {{ value }}
{% endblock %}
```

Then, [configure the product catalog](../product_catalog_configuration/index.md#attribute-rendering-templates) to use it:

```yaml
ibexa_product_catalog:
    templates:
        attributes:
            - 'templates/product/attributes/integer_attribute.html.twig'
```

## Inject templates at runtime

You can inject additional templates by listening to the [`ProductAttributeRenderEvent`](../../api/event_reference/product_catalog_events/index.md#attribute-rendering) event. Use this option when you want to add templates conditionally, for example based on the active catalog engine or region.

```php
<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\ProductCatalog\Events\ProductAttributeRenderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final readonly class MyAttributeRenderSubscriber
{
    #[AsEventListener]
    public function onAttributeRender(ProductAttributeRenderEvent $event): void
    {
        $event->addTemplateBefore(
            'templates/product/attributes/integer_attribute.html.twig',
            '@ibexadesign/product_catalog/product/attributes/attribute_blocks.html.twig',
        );
    }
}
```
