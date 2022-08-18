---
description: Learn how to add settings that format the Field value.
---

# Step 6 - Implement Point 2D settings

Implementing settings enables you to define the format for displaying the Field on the page.
To do so, you will create the `format` field where you will be able to change the way coordinates for Point 2D are displayed.

## Define Field Type format

In this step you will create the `format` field for Point 2D coordinates.
To do that, you need to define a `SettingsSchema` definition.
You will also specify coordinates as placeholder values `%x%` and `%y%`.

Open `src/FieldType/Point2D/Type.php` and add a `getSettingsSchema` method according to the following code block:

```php hl_lines="23 24 25 26 27 28 29 30 31"
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_6/Type.php') =]]
```

## Add a format field

In this part you will define and implement the edit form for your Field Type. 

Define a `Point2DSettingsType` class and add a `format` field in `src/Form/Type/Point2DSettingsType.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/Form/Type/Point2DSettingsType.php') =]]
```

## FieldDefinitionFormMapper Interface

Now, enable the user to add the coordinates which will be validated.
In `src/FieldType/Point2D/Type.php` you will:
 
- implement the `FieldDefinitionFormMapperInterface` interface
- add a `mapFieldDefinitionForm` method at the end that will define the field settings

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 0, 4) =]]
[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 14, 15) =]]

// ...

[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 16, 17) =]]

// ...

[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Type.php', 42, 48) =]]
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

## Field Type definition

To be able to display the new `format` field, you need to add a template for it.
Create `templates/point2d_field_type_definition.html.twig`:

```html+twig
[[= include_file('code_samples/field_types/2dpoint_ft/templates/point2d_field_type_definition.html.twig') =]]
```

### Add configuration for the format field

Next, provide the template mapping in `config/packages/ezplatform.yaml`:

```yaml hl_lines="6 7"
[[= include_file('code_samples/field_types/2dpoint_ft/config/packages/field_templates.yaml') =]]
```

## Redefine template

Finally, redefine the Point 2D template, so it accommodates the new `format` field.

In `templates/point2d_field.html.twig` replace the content with:

```html+twig
[[= include_file('code_samples/field_types/2dpoint_ft/templates/point2d_field.html.twig') =]]
```

## Edit the Content Type

Now, you can go to Admin in the Back Office and see the results of your work by editing the Point 2D Content Type.

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

Add new format `(%x%, %y%)` in the **Format** field as shown in the screen below.

![Point 2D definition with format field](field_definition_format_field.png)
