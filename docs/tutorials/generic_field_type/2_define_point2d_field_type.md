---
description: Learn how to create the Type class which contains the logic for the field.
---

# Step 2 - Define the Point 2D field type

## The Type class

The Type contains logic of the field type: validating data, transforming from various formats, describing the validators, and more.
In this example Point 2D field type extends the `Ibexa\Contracts\Core\FieldType\Generic\Type` class.

For more information about the Type class of a field type, see [Type class](type_and_value.md#type-class).

## Field type identifier

First, create `src/FieldType/Point2D/Type.php`.
Add a `getFieldTypeIdentifier()` method to it.
The new method returns the string that **uniquely** identifies your field type, in this case `point2d`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_2/Type.php') =]]
```

## Add a new service definition

Next, add the `ibexa.field_type` tag to `config/services.yaml`:

```yaml
services:
[[= include_file('code_samples/field_types/2dpoint_ft/config/services.yaml', 33, 36) =]]
```
