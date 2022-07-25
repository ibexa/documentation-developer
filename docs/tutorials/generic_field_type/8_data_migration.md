---
description: Learn how to serialize and deserialize Field data to enable sorting or search.
---

# Step 8 -  Data migration between Field Type versions

Adding data migration enables you to easily change the output of the Field Type to fit your current needs.
This process is important when a Field Type needs to be compared for sorting and searching purposes.
Serialization allows changing objects to array by normalizing them, and then to the selected format by encoding them.
In reverse, deserialization changes different formats into arrays by decoding and then denormalizing them into objects.

For more information on Serializer Components, see [Symfony documentation.]([[= symfony_doc =]]/components/serializer.html)

## Normalization 

First, you need to add support for normalization in a `src/Serializer/Point2D/ValueNormalizer.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/Serializer/Point2D/ValueNormalizer.php') =]]
```

##  Add Normalizer definition

Next, add the `ValueNormalizer` service definition to the `config/services.yaml` with a `serializer.normalizer` tag:
 
```yaml
services:
[[= include_file('code_samples/field_types/2dpoint_ft/config/services.yaml', 39, 42) =]]
```

## Backward compatibility

To accept old versions of the Field Type you need to add support for denormalization in a `src/Serializer/Point2D/ValueDenormalizer.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/Serializer/Point2D/ValueDenormalizer.php') =]]
```

## Add Denormalizer definition

Next, add the `ValueDenormalizer` service definition to `config/services.yaml` with a `serializer.denormalizer` tag:
 
```yaml
services:
[[= include_file('code_samples/field_types/2dpoint_ft/config/services.yaml', 43, 46) =]]
```

## Change format on the fly

To change the format on the fly, you need to replace the constructor in `src/FieldType/Point2D/Value.php`:

```php
[[= include_file('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Value.php', 24, 31) =]]
```

Now you can easily change the internal representation format of the Point 2D Field Type.
