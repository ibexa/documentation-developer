---
description: You can customize which field type metadata should be disabled in the back office.
---

# Customize field type metadata

When creating a content type definition, you add fields and configure their metadata,
such as whether they're required, translatable, and so on.

If needed, you can customize that some of those options are disabled in the back office for specific field types.
To do this, add custom service definition for `ModifyFieldDefinitionsCollectionTypeExtension`.

For example, this configuration means that no Image field can be set as required in the definition of a content type:

``` yaml
services:
    ibexa.field_type_identifier.form.type_extension.modify_field_definitions_for_field_type_identifier_field_type:
        class: 'Ibexa\AdminUi\Form\Type\Extension\ModifyFieldDefinitionsCollectionTypeExtension'
        arguments:
            $fieldTypeIdentifier: 'ezimage'
            $modifiedOptions:
                disable_required_field: true
        tags:
            - form.type_extension
```

`fieldTypeIdentifier` refers to the identifier of the field type, in this case `ezimage`.

`modifiedOptions` lists the changes you want to make. The following options are available:

- `disable_identifier_field` - disables changing the field identifier
- `disable_required_field` - disables setting the field as required
- `disable_translatable_field` - disables setting the field as translatable
- `disable_remove` - disables removing the field from content type definition (after it has been saved)

![Image field with disabled required option](disable-required-field.png)
