---
description: Learn how to add settings that format the field value.
---

# Step 6 - Implement Point 2D settings

Implementing settings enables you to define the format for displaying the field on the page.
To do so, create the `format` field where you're able to change the way coordinates for Point 2D are displayed.

## Define field type format

In this step you create the `format` field for Point 2D coordinates.
To do that, you need to define a `SettingsSchema` definition.
You also specify coordinates as placeholder values `%x%` and `%y%`.

Open `src/FieldType/Point2D/Type.php` and add a `getSettingsSchema` method according to the following code block:

```php hl_lines="18-26"
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_6/Type.php') =]]
```

## Add a format field

In this part you define and implement the edit form for your field type.

Define a `Point2DSettingsType` class and add a `format` field in `src/Form/Type/Point2DSettingsType.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/Form/Type/Point2DSettingsType.php') =]]
```

## FieldDefinitionFormMapper Interface

Now, enable the user to add the coordinates which are validated.
In `src/FieldType/Point2D/Type.php` you:

- implement the `FieldDefinitionFormMapperInterface` interface
- add a `mapFieldDefinitionForm` method at the end that defines the field settings

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 0, 4) =]]
[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 7, 8) =]]

// ...

[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 14, 15) =]]

// ...

[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 40, 46) =]]
```

<details class="tip">
<summary>Complete Type.php code</summary>
```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php') =]]
```
</details>

## Add a new tag

Next, add `FieldDefinitionFormMapper` as an extra tag definition for `App\FieldType\Point2D\Type` in `config/services.yaml`:

```yaml hl_lines="5"
[[= include_file('code_samples/field_types/2dpoint_ft/config/services.yaml', 33, 38) =]]
```

## Field type definition

To be able to display the new `format` field, you need to add a template for it.
Create `templates/point2d_field_type_definition.html.twig`:

```html+twig
[[= include_file('code_samples/field_types/2dpoint_ft/templates/point2d_field_type_definition.html.twig') =]]
```

### Add configuration for the format field

Next, provide the template mapping in `config/packages/ibexa.yaml`:

```yaml hl_lines="6 7"
[[= include_file('code_samples/field_types/2dpoint_ft/config/packages/field_templates.yaml') =]]
```

## Redefine template

Finally, redefine the Point 2D template, so it accommodates the new `format` field.

In `templates/point2d_field.html.twig` replace the content with:

```html+twig
[[= include_file('code_samples/field_types/2dpoint_ft/templates/point2d_field.html.twig') =]]
```

## Edit the content type

Now, in the back office, you can go to **Content types** and see the results of your work by editing the Point 2D content type.

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

Add new format `(%x%, %y%)` in the **Format** field as shown in the screen below.

![Point 2D definition with format field](field_definition_format_field.png)
