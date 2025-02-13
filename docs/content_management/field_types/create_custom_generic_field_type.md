---
description: Create a new field type based on the Generic field type.
---

# Create custom generic field type

The Generic field type is an abstract implementation of field types holding structured data for example, address.
You can use it as a base for custom field types.
The Generic field type comes with the implementation of basic methods,
reduces the number of classes which must be created, and simplifies the tagging process.

A more in-depth, step-by-step tutorial can be viewed here: [Creating a Point 2D field type](creating_a_point2d_field_type.md).

!!! tip

    You should not use the Generic field type when you need a very specific implementation or complete control over the way data is stored.

[[= include_file('docs/snippets/simple_hash_value_caution.md') =]]

## Define value object

First, create `Value.php` in the `src/FieldType/HelloWorld` directory.
The Value class of a field type contains only the basic logic of a field type, the rest of it's handled by the `Type` class.
For more information about field type Value, see [Value handling](type_and_value.md#value-handling).

The `HelloWorld` Value class should contain:

- public properties that retrieve `name`
- an implementation of the `__toString()` method

```php
[[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Value.php') =]]
```

## Define fields and configuration

Next, implement a definition of a field type extending the Generic field type in the `src/FieldType/HelloWorld/Type.php` class.
It provides settings for the field type and an implementation of the `Ibexa\Contracts\Core\FieldType\FieldType` abstract class.

```php
[[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Type.php', 0, 6) =]][[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Type.php', 9, 16) =]]}
```

For more information about the Type class of a field type, see [Type class](type_and_value.md#type-class).

Next, register the field type as a service and tag it with `ibexa.field_type`:

```yaml
[[= include_file('code_samples/field_types/generic_ft/config/custom_services.yaml', 0, 5) =]]
```

## Define form for value object

Create a `src/Form/Type/HelloWorldType.php` form.
It enables you to edit the new field type.

```php
[[= include_file('code_samples/field_types/generic_ft/src/Form/Type/HelloWorldType.php') =]]
```

Now you can map field definitions into Symfony forms with FormMapper.
Add the `mapFieldValueForm()` method required by `FieldValueFormMapperInterface`
and the required `use` statements to `src/FieldType/HelloWorld/Type.php`:

```php hl_lines="6-7 18-26"
[[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Type.php') =]]
```

For more information about the FormMappers, see [field type form and template](form_and_template.md).

Next, add the `ibexa.admin_ui.field_type.form.mapper.value` tag to the service definition:

```yaml hl_lines="6"
[[= include_file('code_samples/field_types/generic_ft/config/custom_services.yaml', 0, 6) =]]
```

## Render fields

### Create a template

Create a template for the new field type. It defines the default rendering of the `HelloWorld` field.
In the `templates/themes/standard/field_types` directory create a `field_type.html.twig` file:

```html+twig
[[= include_file('code_samples/field_types/generic_ft/templates/themes/standard/field_types/field_type.html.twig') =]]
```

### Template mapping

Provide the template mapping under the `ibexa.system.<scope>.field_templates` [configuration key](configuration.md#configuration-files):

```yaml
[[= include_file('code_samples/field_types/generic_ft/config/packages/field_templates.yaml', 0, 5) =]]
```

## Final results

Finally, you should be able to add a new content type in the back office interface.
Navigate to **Content types** tab and under **Content** category create a new content type:

![Creating new content type](extending_field_type_create.png)

Next, define a **Hello World** field:

![Defining Hello World](extending_field_type_definition.png)

After saving, your **Hello World** content type should be available under **Content** in the sidebar menu.

![Creating Hello World](extending_field_type_hello_world.png)

For more detailed tutorial on Generic field type follow [Creating a Point 2D field type](creating_a_point2d_field_type.md).
