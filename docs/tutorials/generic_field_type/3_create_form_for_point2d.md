---
description: Learn how to create a form used for editing a custom field definition.
---

# Step 3 - Create a form for editing field type

## Create a form

To edit your new field type, create a `Point2DType.php` form in the `src/Form/Type` directory.
Next, add a `Point2DType` class that extends the `AbstractType` and implements the `buildForm()` method.
This method adds fields for `x` and `y` coordinates.

```php
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_3/Point2DType.php', 0, 18) =]]
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_3/Point2DType.php', 25, 26) =]]
```

## Add a Form Mapper Interface

The FormMapper adds the field definitions into Symfony forms using the `add()` method. 
The `FieldValueFormMapperInterface` provides an edit form for your field type in the administration interface.
For more information about the FormMappers, see [field type form and template](form_and_template.md).

First, implement a `FieldValueFormMapperInterface` interface (`Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface`) to field type definition in the `src/FieldType/Point2D/Type.php`.

Next, implement a `mapFieldValueForm()` method and invoke `FormInterface::add` method with the following arguments (highlighted lines):

- Name of the property the field value maps to: `value`
- Type of the field: `Point2DType::class`
- Custom options: `required` and `label`

Final version of the Type class should have the following statements and functions:

```php hl_lines="7 10 19 20 21 22 23 24 25 26"
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_3/Type.php') =]]
```

Finally, add a `configureOptions` method and set default value of `data_class` to `Value::class` in `src/Form/Type/Point2DType.php`.
It allows your form to work on this object.

```php hl_lines="19 20 21 22 23 24"
[[= include_file('code_samples/field_types/2dpoint_ft/src/Form/Type/Point2DType.php') =]]
```

## Add a new tag

Next, add the `ibexa.admin_ui.field_type.form.mapper.value` tag to `config/services.yaml`:

```yaml hl_lines="4"
[[= include_file('code_samples/field_types/2dpoint_ft/config/services.yaml', 33, 37) =]]
```
