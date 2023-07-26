---
description: Learn how to add a template for rendering the custom Field on the site front.
---

# Step 4 - Introduce a template

## Point 2D template

In order to display data from the Field Type, you need to create and register a template for it.
Each Field Type template receives a set of variables that can be used to achieve the desired goal.
In this case the most important variable is the `field`, an instance of `Ibexa\Contracts\Core\Repository\Values\Content\Field`.
In addition to its own metadata (`id`, `fieldDefIdentifier`, etc.), it exposes the Field Value through the `value` property.

Remember that Field Type templates can be overridden in order to tweak what is displayed and how.
For more information, see the documentation about [Field Type templates](form_and_template.md#content-view-templates).

First, create a `point2d_field.html.twig` template in the `templates` directory.
It will define the default display of a Point 2D.
Your basic template for Point 2D should look like this:

```html+twig
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_4/point2d_field.html.twig') =]]
```

## Template mapping

Next, provide the template mapping in `config/packages/ezplatform.yaml`:

```yaml
[[= include_file('code_samples/field_types/2dpoint_ft/config/packages/field_templates.yaml', 0, 5) =]]
```
