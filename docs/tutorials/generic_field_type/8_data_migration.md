---
description: Learn how to serialize and deserialize field data to enable sorting or search.
---

# Step 8 -  Data migration between field type versions

Adding data migration enables you to change the output of the field type to fit your current needs.
This process is important when a field type needs to be compared for sorting and searching purposes.
Serialization allows changing objects to array by normalizing them, and then to the selected format by encoding them.
In reverse, deserialization changes different formats into arrays by decoding and then denormalizing them into objects.

For more information on Serializer Component, see [Symfony documentation]([[= symfony_doc =]]/serializer.html).

## Normalization

First, you need to add support for normalization in a `src/Serializer/Point2D/ValueNormalizer.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/Serializer/Point2D/ValueNormalizer.php') =]]
```

!!! note

    The `ValueDenormalizer` and `ValueNormalizer` service definitions are automatically registered by Symfony as services in `config/services.yaml`, without the need to manually define them.

## Backward compatibility

To accept old versions of the field type you need to add support for denormalization in a `src/Serializer/Point2D/ValueDenormalizer.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/Serializer/Point2D/ValueDenormalizer.php') =]]
```

## Change format on the fly

To change the format on the fly, you need to replace the constructor and class properties in `src/FieldType/Point2D/Value.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/ValueFinal.php', 10, 24) =]]
```

Now you can change the internal representation format of the Point 2D field type.
