# Null field type

This field type is used as fallback for migration scenarios, and for testing purposes.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Null` | variable    | mixed             |

## Description

The Null field type serves as an aid when migrating from eZ Publish Platform and earlier legacy versions.
It's a dummy for legacy field types that aren't implemented in [[= product_name =]].

Null field type accepts anything provided as a value and is usually combined with:

- NullConverter: Makes it not store anything to the legacy storage engine (database), nor it reads any data.
- Unindexed: Indexable class making sure nothing is indexed to configured search engine.

This field type doesn't have its own fixed internal name.
Its identifier is instead configured as needed by passing it as an argument to the constructor.

### Example for usage of Null field type

The following example shows how an `example` field type could be configured as a Null field type:

``` yaml
# Null Fieldtype example configuration
services:
    ibexa.field_type.example:
        class: Ibexa\Core\FieldType\Null\Type
        arguments: [example]
        tags: [{name: ibexa.field_type, alias: example}]
    ibexa.field_type.example.converter:
        class: Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter
        tags: [{name: ibexa.field_type.storage.legacy.converter, alias: example}]
    ibexa.field_type.example.indexable:
        class: Ibexa\Core\FieldType\Unindexed
        tags: [{name: ibexa.field_type.indexable, alias: example}]
```
