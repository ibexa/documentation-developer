# Step 2 - Define the Point 2D Field Type

## The Type class

The Type contains logic of the Field Type: validating data, transforming from various formats, describing the validators, etc.
In this example Point 2D Field Type will extend the `eZ\Publish\SPI\FieldType\Generic\Type` class.
For more information about the Type class of a Field Type, see [Type class](../../api/field_type_type_and_value.md#type-class).

## Field Type identifier

First, create `src/FieldType/Point2D/Type.php`.
Add a `getFieldTypeIdentifier()` method to it. The new method will return the string that **uniquely** identifies your Field Type, in this case `point2d`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/steps/step_2/Type.php') =]]
```

## Add a new service definition

Next, add the `ezplatform.field_type` tag to `config/services.yaml`:

```yaml
services:
[[= include_file('code_samples/field_types/2dpoint_ft/config/services.yaml', 33, 36) =]]
```
