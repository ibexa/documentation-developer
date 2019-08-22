# Step 4 - Introduce a template

!!! tip

    You can find all files used and modified in this step on [GitHub]().

In order to display data of the Field Type from templates, you need to create and register a template for it.

!!! tip

    See documentation about [Field Type templates](../../api/field_type_form_and_template.md) and about [importing settings from a bundle](../../cookbook/importing_settings_from_a_bundle.md).

## Point2D template

The first thing to do is create the template. It will define the default display of a Point2D.
Remember that [Field Type templates can be overridden](../../guide/twig_functions_reference.md#override-a-field-template-block) in order to tweak what is displayed and how.

Each Field Type template receives a set of variables that can be used to achieve the desired goal.
The variable important in this case is `field`, an instance of `eZ\Publish\API\Repository\Values\Content\Field`.
In addition to its own metadata (`id`, `fieldDefIdentifier`, etc.), it exposes the Field Value through the `value` property.

A basic template (`templates/field_type.html.twig`) is:

``` html+twig
{% block point2d_field %}
    ({{ field.value.getX() }}, {{ field.value.getY() }})
{% endblock %}
```

`field.value.getX` and  `field.value.getY` are piped through the `raw` twig operator, since the variable contains HTML code.
Without it, the HTML markup would be visible directly, because Twig escapes variables by default.

## Template mapping

Next, provide the template mapping in `config/packages/ezplatform.yaml`:

``` yml
system:
    default:
        field_templates:
            - { template: 'field_type.html.twig', priority: 0 }
```

