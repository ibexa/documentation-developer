# Add custom Field Types to GraphQL

If you want to use  custom Field Types in GraphQL, you need to map them.
Custom Field Types have values and field definition structure,
that need to be defined, for GraphQL to read them.
For example:

|Name| Possible field value | Resolver |Field definition|
|---|---|---|---|
|Text Line| string | default |`TextLineFieldDefinition`
|Relation List| `DomainContent` `ArticleContent` `ImageContent` |customized| `RelationListFieldDefinition`|

## Map a custom Field Type

There are two ways to map a custom Field Type:

- configuration
- custom `FieldDefinitionMapper`

If the mapping of your field type depends on the field definition, you need to write a custom `FieldDefinitionMapper`.
Otherwise, you can map with configuration.

### Map with configuration

To map a custom Field Type with configuration use a compiler pass to modify a container parameter, `ibexa.graphql.schema.content.mapping.field_definition_type`.

It is a hash that maps a Field Type identifier (`ezstring`) to the following entries:

- `value_type` - the GraphQL type values of custom field. It can be a native type (`string`, `int`), or a custom type. If none is specified, `string` will be used.
- `value_resolver` - how values of this field are resolved and passed to the defined value type.  If not specified, it will receive the `Field` object for the field type: `field`.
- `definition_type` - the GraphQL type field definitions. If not specified, it will use `FieldDefinition`.

Compiler pass example:

```php
namespace Ibexa\Bundle\FieldTypeQuery\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LandingPageGraphQLConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('ibexa.graphql.schema.content.mapping.field_definition_type')) {
            return;
        }

        $mapping = $container->getParameter('ibexa.graphql.schema.content.mapping.field_definition_type');
        $mapping['my_custom_fieldtype'] = [
            'value_type' => 'MyCustomFieldValue',
            'definition_type' => 'MyCustomFieldDefinition',
            'value_resolver' => 'field.someProperty'
        ];
    }
}
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
            $innerMapper: '@App\GraphQL\Schema\MyCustomFieldDefinitionMapper'
```

The `$innerMapper` argument will pass the decorated mapper to the constructor.
You can use the `DecoratingFieldDefinitionMapper` from the `graphql` package.
It requires that you implement the `getFieldTypeIdentifier()` method to tell which Field Type is covered by the mapper:

```php
namespace App\GraphQL\Schema;

use Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper
use Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionMapper;

class MyCustomFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper
{
    protected function getFieldTypeIdentifier(): string
    {
        return 'my_custom_field_type';
    }
}
```

The `FieldDefinitionMapper` interface defines three methods:
- `mapToFieldValueType()` - returns the GraphQL type value of this field are mapped to.
- `mapToFieldValueResolver()` - returns the resolver, as an expression language string, values are resolved with.
- `mapToFieldDefinitionType()` - returns the GraphQL type field definitions of this type are mapped to.

Implement only the methods that you need, the rest will be handled by other mappers (configuration or default).

The `RelationFieldDefinitionMapper` example:

```php
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
            $type = $this->nameHelper->domainContentName($contentType);
        } else {
            $type = 'DomainContent';
        }

        if ($this->isMultiple($fieldDefinition)) {
            $type = "[$type]";
        }

        return $type;
    }

    /**
     * The resolver uses a boolean argument `isMultiple` that depends on the selection limit setting.
     */
    public function mapToFieldValueResolver(FieldDefinition $fieldDefinition): ?string
    {
        if (!$this->canMap($fieldDefinition)) {
            return parent::mapToFieldValueResolver($fieldDefinition);
        }

        $isMultiple = $this->isMultiple($fieldDefinition) ? 'true' : 'false';

        return sprintf('@=resolver("DomainRelationFieldValue", [field, %s])', $isMultiple);
    }

    private function isMultiple(FieldDefinition $fieldDefinition)
    {
        $constraints = $fieldDefinition->getValidatorConfiguration();

        return isset($constraints['RelationListValueValidator'])
            && $constraints['RelationListValueValidator']['selectionLimit'] !== 1;
    }
}
```

The value type depends on the field definition allowed content types setting:
- if one and only one content type is allowed, the value will be of this type
- if there are no restrictions, or several types are allowed, the value will be a `DomainContent`

The cardinality (single or collection) depends on the selection limit setting:
- if only one item is allowed, the value is unique: `ArticleContent`, `DomainContent`
- if there are no limits, or a limit larger than 1, the value is a collection: `"[ArticleContent]"`, `"[DomainContent]"`.


#### Field Definition Input Mappers

`FieldDefinitionInputMapper` interface is used if the input for the field depends on the field definition.
For instance, `ezmatrix` generates its own input types depending on the configured columns. 
It defines an extra method, `mapToFieldValueInputType`, that returns a GraphQL type for a Field Definition.

Example:

```php
class MyFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper, FieldDefinitionInputMapper
{
    public function mapToFieldValueInputType(ContentType $contentType, FieldDefinition $fieldDefinition): ?string
    {
        if (!$this->canMap($fieldDefinition)) {
            return parent::mapToFieldValueInputType($fieldDefinition);
        }

        return $this->nameMyFieldType($fieldDefinition);
    }
}
```

In 2.0, `FieldDefinitionInputMapper` and `FieldDefinitionMapper` will be merged, and the service tag will be deprecated.

## Resolver expressions

Two variables are available in the resolver's expression:

- `field` is the current field, as an extension of the API's Field object that proxies properties requests to the Field Value
- `content` is the resolved content item's `ContentInfo`

`RelationFieldValueBuilder` or `SelectionFieldValueBuilder` can be used as examples.