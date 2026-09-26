# Step 4 - Introduce a template

Learn how to add a template for rendering the custom field on the site front.

## Point 2D template

To display data from the field type, you need to create and register a template for it. Each field type template receives a set of variables that can be used to achieve the desired goal. In this case the most important variable is the `field`, an instance of `Ibexa\Contracts\Core\Repository\Values\Content\Field`. In addition to its own metadata (for example, `id` or `fieldDefIdentifier`), it exposes the field Value through the `value` property.

Remember that field type templates can be overridden to tweak what is displayed and how.

For more information, see [field type templates](../../../content_management/field_types/form_and_template/index.md#content-view-templates).

First, create a `point2d_field.html.twig` template in the `templates` directory. It defines the default display of a Point 2D. Your basic template for Point 2D should look like this:

```html+twig
{% block point2d_field %}
    ({{ field.value.getX() }}, {{ field.value.getY() }})
{% endblock %}
```

## Template mapping

Next, provide the template mapping in `config/packages/ibexa.yaml`:

```yaml
ibexa:
    system:
        default:
            field_templates:
                - { template: 'point2d_field.html.twig', priority: 0 }
```
