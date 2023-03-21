---
description: Add custom Field Types to GraphQL.
---

# Add custom Field Types to GraphQL

If you want to use custom Field Types in GraphQL, you need to map them.
Their values and field definition structure, need to be defined, for GraphQL to read them.
For example:

| Name | Possible field value      | Resolver| Field definition|
|------|------| ------- | ------- |
| Text Line     | string | default | `TextLineFieldDefinition`    |
| Relation List | `Item` `ArticleItem` `ImageItem` | customized | `RelationListFieldDefinitio` |

## Map a custom Field Type

There are two ways to map a custom Field Type:

- configuration
- custom `FieldDefinitionMapper`

You need to write a custom `FieldDefinitionMapper` if the field definition settings and constraints impact how it is mapped to GraphQL.
For example, the selection Field Type has a "multiple" option. 
If set to false, it will accept and return a single value, 
but if set to true, it will accept and return an array of values.

If your field definition doesn't require additional clarifications, you can map with configuration.

### Map with configuration

To map a custom Field Type with configuration use a compiler pass to modify a container parameter, `ibexa.graphql.schema.content.mapping.field_definition_type`.

It is a hash that maps a Field Type identifier (`ezstring`) to the following entries:

- `value_type` - the GraphQL type values of the custom field. It can be a native type (string, int), or a custom type. If none is specified, string will be used.
- `value_resolver` - how values of this field are resolved and passed to the defined value type. If not specified, it will receive the `Field` object for the field type: `field`.
- `definition_type` - the GraphQL type the field definitions is mapped to. If not specified, it will use `FieldDefinition`.

Compiler pass example that should be placed in `src/DependencyInjection/Compiler`:

``` php
[[= include_file('code_samples/api/graphql/src/DependencyInjection/Compiler/MyCustomTypeGraphQLCompilerPass.php') =]]
```

### Map with a custom `FieldDefinitionMapper`

The `FieldDefinitionMapper` API uses service decorators.
To register your own mapper, make it decorate the
`Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper` service:

```yaml
services:
    App\GraphQL\Schema\MyCustomFieldDefinitionMapper:
        decorates: Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper
        arguments:
            $innerMapper: '@.inner'
```

The `$innerMapper` argument will pass the decorated mapper to the constructor.
You can use the `DecoratingFieldDefinitionMapper` from the `graphql` package.
It requires that you implement the `getFieldTypeIdentifier` method to tell which Field Type is covered by the mapper.

Add `MyCustomFieldDefinitionMapper.php` mapper to `src/GraphQL/Schema`:

``` php
[[= include_file('code_samples/api/graphql/src/GraphQL/Schema/MyCustomFieldDefinitionMapper.php') =]]
```

The `FieldDefinitionMapper` interface defines following methods:

- `mapToFieldValueType` - returns the GraphQL type value for the defined field
- `mapToFieldValueInputType` - returns the GraphQL type value for the field input value
- `mapToFieldValueResolver` - returns the resolver, as an expression language string, values are resolved with
- `mapToFieldDefinitionType`- returns the GraphQL type field definitions of the mapped type

Only implement methods that you need, the rest will be handled by other mappers (configuration or default).
When the mapper method is decorated, you need to block the if statement for unsupported types (if (notasupportedtype) call parent method).
To do that, you need to replace "mapXXX` by the method it is in:

```php
        if (!$this->canMap($fieldDefinition)) {
             return parent::mapToFieldValueType($fieldDefinition);
         }
```

It is required for every method that is implemented, so that other mappers are called for other Field Types.

The [`RelationFieldDefinitionMapper`](https://github.com/ibexa/graphql/blob/main/src/lib/Schema/Domain/Content/Mapper/FieldDefinition/RelationFieldDefinitionMapper.php) example:

```php hl_lines="14"
class RelationFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper
{
    public function mapToFieldValueType(FieldDefinition $fieldDefinition): ?string
    {
        if (!$this->canMap($fieldDefinition)) {
            return parent::mapToFieldValueType($fieldDefinition);
        }
        $settings = $fieldDefinition->getFieldSettings();

        if (count($settings['selectionContentTypes']) === 1) {
            $contentType = $this->contentTypeService->loadContentTypeByIdentifier($settings['selectionContentTypes'][0]);
            $type = $this->nameHelper->itemName($contentType);
        } else {
            $type = 'Item';
        }

        if (this->isMultiple(fieldDefinition)) {
            type = "[type]";
        }

        return $type;
    }

    public function mapToFieldValueResolver(FieldDefinition $fieldDefinition): ?string
    {
        if (!$this->canMap($fieldDefinition)) {
            return parent::mapToFieldValueResolver($fieldDefinition);
        }

        isMultiple = this->isMultiple($fieldDefinition) ? 'true' : 'false';

        return sprintf('@=resolver("DomainRelationFieldValue", [field, %s])', $isMultiple);
    }

    private function isMultiple(FieldDefinition $fieldDefinition)
    {
        $constraints = $fieldDefinition->getValidatorConfiguration();

        return isset(constraints['RelationListValueValidator'])
            && constraints'RelationListValueValidator' !== 1;
  }
}
```

The value type depends on the field definition allowed Content Types setting:

- for types that return content items if there are no restrictions, or several types are allowed, the value will be an `Item`

The cardinality (single or collection) depends on the selection limit setting:

- if only one item is allowed, the value is unique: `ArticleItem`, `FolderItem`
- if there are no limits, or the limit is larger than 1, the value is a collection: `"[ArticleItem]", "[FolderItem]"`.

#### Field input mapping

The `mapToFieldValueInputType` method is used to document what input type is expected by Field Types that require a more complex input value.
For instance, `ezmatrix` generates its own input types depending on the configured columns.

Example of a `MyCustomFieldDefinitionMapper` mapper for a complex Field Type:

```php
class MyFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper
{
    public function mapToFieldValueInputType(ContentType contentType, FieldDefinition fieldDefinition): ?string
    {
        if (!this->canMap(fieldDefinition)) {
            return parent::mapToFieldValueInputType($fieldDefinition);
        }

        return this->nameMyFieldType(fieldDefinition);
    }
}
```

## Resolver expressions

Below variables are available in the resolver's expression:

- `field` is the current field, as an extension of the API's Field object that proxies properties requests to the Field Value
- `content` is the resolved content item's `Content`
- `location` is the content item's resolved location, for more information, see [Querying Locations](graphql_queries.md#querying-locations)
- `item` is the content together with its location (`\Ibexa\GraphQL\Value\Item`)

`RelationFieldValueBuilder` or `SelectionFieldValueBuilder` can be used as examples.