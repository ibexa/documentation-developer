# Null Field Type

This Field Type is used as fallback for migration scenarios, and for testing purposes.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Null` | variable    | mixed             |

## Description

The Null Field Type serves as an aid when migrating from eZ Publish Platform and earlier legacy versions. It is a dummy for legacy Field Types that are not implemented in [[= product_name =]].

Null Field Type will accept anything provided as a value and is usually combined with:

- NullConverter: Makes it not store anything to the legacy storage engine (database), nor will it read any data.
- Unindexed: Indexable class making sure nothing is indexed to configured search engine.

This Field Type does not have its own fixed internal name. Its identifier is instead configured as needed by passing it as an argument to the constructor.

### Example for usage of Null Field Type

The following example shows how an `example` Field Type could be configured as a Null Field Type:

``` yaml
# Null Fieldtype example configuration
services:
    ezpublish.fieldType.example:
        class: eZ\Publish\Core\FieldType\Null\Type
        autowire: true
        autoconfigure: false
        arguments: [example]
        tags: [{name: ezplatform.field_type, alias: example}]
    ezpublish.fieldType.example.converter:
        class: eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter
        tags: [{name: ezplatform.field_type.legacy_storage.converter, alias: example}]
    ezpublish.fieldType.example.indexable:
        class: '%ezpublish.fieldType.indexable.unindexed.class%'
        tags: [{name: ezplatform.field_type.indexable, alias: example}]
```
