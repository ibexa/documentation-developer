---
description: Learn how to add a template for rendering the custom field on the site front.
---

# Step 4 - Introduce a template

## Point 2D template

To display data from the field type, you need to create and register a template for it.
Each field type template receives a set of variables that can be used to achieve the desired goal.
In this case the most important variable is the `field`, an instance of `Ibexa\Contracts\Core\Repository\Values\Content\Field`.
In addition to its own metadata (`id`, `fieldDefIdentifier`, etc.), it exposes the field Value through the `value` property.

Remember that field type templates can be overridden to tweak what is displayed and how.
For more information, see the documentation about [field type templates](form_and_template.md#content-view-templates).

First, create a `point2d_field.html.twig` template in the `templates` directory.
It defines the default display of a Point 2D.
Your basic template for Point 2D should look like this:

```html+twig
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_4/point2d_field.html.twig') =]]
```

## Template mapping

Next, provide the template mapping in `config/packages/ibexa.yaml`:

```yaml
[[= include_file('code_samples/field_types/2dpoint_ft/config/packages/field_templates.yaml', 0, 5) =]]
```
