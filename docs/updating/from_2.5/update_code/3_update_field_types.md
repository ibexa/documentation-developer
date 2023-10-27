# 4.3. Update Field Types

You need to adapt your custom Field Types to the new Field Type architecture.

## `eZ\Publish\SPI\FieldType\FieldType` interface

The `eZ\Publish\SPI\FieldType\FieldType` interface is now an abstract class.
You need to replace `implements FieldType` in your Field Type code with `extends FieldType`.

## Deprecated `getName` method

The deprecated method `getName` from the `eZ\Publish\SPI\FieldType\FieldType` interface has been changed.
Now it accepts two additional parameters: `FieldDefinition $fieldDefinition` and `string $languageCode`.

In your code you need to change the `getName` signature
to `function getName(Value $value, FieldDefinition $fieldDefinition, string $languageCode): string;`.

## `eZ\Publish\SPI\FieldType\Nameable` interface

The `eZ\Publish\SPI\FieldType\Nameable` interface has been removed.
In your code you need to remove implementations of `Nameable` and replace them with
`eZ\Publish\SPI\FieldType\FieldType::getName`.

## Deprecated tags

You need to replace deprecated tags in service configuration:

|Deprecated tag|Current tag|
|---|---|
|ezpublish.fieldType.parameterProvider|ezplatform.field_type.parameter_provider|
|ezpublish.fieldType.externalStorageHandler|ezplatform.field_type.external_storage_handler|
|ezpublish.fieldType.externalStorageHandler.gateway|ezplatform.field_type.external_storage_handler.gateway|
|ezpublish.fieldType|ezplatform.field_type|
|ezpublish.fieldType.indexable|ezplatform.field_type.indexable|
|ezpublish.storageEngine.legacy.converter|ezplatform.field_type.legacy_storage.converter|
|ez.fieldFormMapper.definition|ezplatform.field_type.form_mapper.definition|
|ez.fieldFormMapper.value|ezplatform.field_type.form_mapper.value|

## Moved classes

You need to replace importing the following classes:

|Previous location|Current location|
|---|---|
|EzSystems\RepositoryForms\Data\Content\FieldData|EzSystems\EzPlatformContentForms\Data\Content\FieldData|
|EzSystems\RepositoryForms\Data\FieldDefinitionData|EzSystems\EzPlatformAdminUi\Form\Data\FieldDefinitionData|
|EzSystems\RepositoryForms\FieldType\FieldDefinitionFormMapperInterface|EzSystems\EzPlatformAdminUi\FieldType\FieldDefinitionFormMapperInterface|
|EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface|EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface|

## Extending Field Type templates

If you extended templates for `ezobjectrelationlist_field`, `ezimageasset_field`, or `ezobjectrelation_field` Fields
using `{% extends "@EzPublishCore/content_fields.html.twig" %}`,
you now need to extend `EzSystemsPlatformHttpCache` instead, if you wish to make use of cache:
`{% extends "@EzSystemsPlatformHttpCache/content_fields.html.twig" %}`.
