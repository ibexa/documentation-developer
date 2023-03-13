---
description: You can customize which Field Type metadata should be disabled in the Back Office.
---

# Customize Field Type metadata

When creating a Content Type definition, you add Fields and configure their metadata,
such as whether they are required, translatable, and so on.

If needed, you can customize that some of those options are disabled in the Back Office for specific Field Types.
You do this by adding custom service definition for `ModifyFieldDefinitionsCollectionTypeExtension` 

For example, this configuration means that no Image Field can be set as required in the definition of a Content Type:

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

`fieldTypeIdentifier` refers to the identifier of the Field Type, in this case `ezimage`.

`modifiedOptions` lists the changes you want to make. The following options are available:

- `disable_identifier_field` - disables changing the Field identifier
- `disable_required_field` - disables setting the Field as required
- `disable_translatable_field` - disables setting the Field as translatable
- `disable_remove` - disables removing the Field from Content Type definition (after it has been saved)

![Image Field with disabled required option](disable-required-field.png)
