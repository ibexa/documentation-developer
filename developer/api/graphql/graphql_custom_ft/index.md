# Add GraphQL support to custom field types

Add GraphQL support to custom field types.

If you want to use custom field types in GraphQL, you need to map them. Their values and field definition structure, need to be defined, to interact with them using GraphQL. For example:

| Name          | Possible field value             | Resolver   | Field definition             |
| ------------- | -------------------------------- | ---------- | ---------------------------- |
| Text Line     | string                           | default    | `TextLineFieldDefinition`    |
| Relation List | `Item` `ArticleItem` `ImageItem` | customized | `RelationListFieldDefinitio` |

## Map a custom field type

There are two ways of mapping a custom field type:

- configuration
- custom `FieldDefinitionMapper`

You need to write a custom `FieldDefinitionMapper` if the field definition settings and constraints impact how it's mapped to GraphQL. For example, the selection field type has a "multiple" option. If set to false, it accepts and returns a single value, but if set to true, it accepts and returns an array of values.

If your field definition doesn't require additional clarifications, you can map it with configuration.

### Map with configuration

To map a custom field type with configuration use a compiler pass to modify a container parameter, `ibexa.graphql.schema.content.mapping.field_definition_type`.

It's a hash that maps a field type identifier (`ibexa_string`) to the following entries:

- `value_type` - the GraphQL type values of the custom field. It can be a native type (string, int), or a custom type. If none is specified, string is used.
- `value_resolver` - how values of this field are resolved and passed to the defined value type. If not specified, it receives the `Field` object for the field type: `field`.
- `definition_type` - the GraphQL type the field definitions is mapped to. If not specified, it uses `FieldDefinition`.

Compiler pass example that should be placed in `src/DependencyInjection/Compiler`:

```php
<?php declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MyCustomTypeGraphQLCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('ibexa.graphql.schema.content.mapping.field_definition_type')) {
            return;
        }

        $mapping = $container->getParameter('ibexa.graphql.schema.content.mapping.field_definition_type');
        $mapping['my_custom_fieldtype'] = [
            'value_type' => 'MyCustomFieldValue',
            'definition_type' => 'MyCustomFieldDefinition',
            'value_resolver' => 'field.someProperty',
        ];
    }
}
```

### Map with a custom `FieldDefinitionMapper`

The `FieldDefinitionMapper` API uses service decorators. To register your own mapper, make it decorate the `Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper` service:

```yaml
services:
    App\GraphQL\Schema\MyFieldDefinitionMapper:
        decorates: Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper
        arguments:
            $innerMapper: '@.inner'
```

The `$innerMapper` argument passes the decorated mapper to the constructor. You can use the `DecoratingFieldDefinitionMapper` from the `graphql` package. It requires that you implement the `getFieldTypeIdentifier` method to tell which field type is covered by the mapper.

Add `MyFieldDefinitionMapper.php` mapper to `src/GraphQL/Schema`:

```php
<?php declare(strict_types=1);

namespace App\GraphQL\Schema;

use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\Core\Repository\Values\ContentType\FieldDefinition;
use Ibexa\Contracts\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionMapper;
use Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class MyFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper
{
    protected function getFieldTypeIdentifier(): string
    {
        return 'my_field_type';
    }
}
```

The `FieldDefinitionMapper` interface defines following methods:

- `mapToFieldValueType` - returns the GraphQL type value for the defined field
- `mapToFieldValueInputType` - returns the GraphQL type value for the field input value
- `mapToFieldValueResolver` - returns the resolver, as an expression language string, values are resolved with
- `mapToFieldDefinitionType`- returns the GraphQL type field definitions of the mapped type

Only implement methods that you need, the rest is handled by other mappers (configuration or default). When a mapper method is decorated, you need to call the decorated service method for unsupported types. To do that, you need to replace `mapXXX` by the method it's in:

```php
if (!$this->canMap($fieldDefinition)) {
    return parent::mapToFieldValueInputType($contentType, $fieldDefinition);
}
```

It's required for every implemented method, so that other mappers are called for the other field types.

For an example implementation, look at the [`RelationFieldDefinitionMapper`](https://github.com/ibexa/graphql/blob/5.0/src/lib/Schema/Domain/Content/Mapper/FieldDefinition/RelationFieldDefinitionMapper.php) class.

The value type depends on the field definition allowed content types setting:

- for types that return content items if there are no restrictions, or several types are allowed, the value is an `Item`

The cardinality (single or collection) depends on the selection limit setting:

- if only one item is allowed, the value is unique: `ArticleItem`, `FolderItem`
- if there are no limits, or the limit is larger than 1, the value is a collection: `"[ArticleItem]", "[FolderItem]"`.

#### Field input mapping

The `mapToFieldValueInputType` method is used to document what input type is expected by field types that require a more complex input value. For example, `ibexa_matrix` generates its own input types depending on the configured columns.

Example of a `MyFieldDefinitionMapper` mapper for a complex field type:

```php
<?php declare(strict_types=1);

namespace App\GraphQL\Schema;

use Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType;
use Ibexa\Contracts\Core\Repository\Values\ContentType\FieldDefinition;
use Ibexa\Contracts\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionMapper;
use Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class MyFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper
{
    protected function getFieldTypeIdentifier(): string
    {
        return 'my_field_type';
    }

    #[\Override]
    public function mapToFieldValueInputType(ContentType $contentType, FieldDefinition $fieldDefinition): ?string
    {
        if (!$this->canMap($fieldDefinition)) {
            return parent::mapToFieldValueInputType($contentType, $fieldDefinition);
        }

        return $this->nameMyFieldInputType($contentType, $fieldDefinition);
    }

    private function nameMyFieldInputType(ContentType $contentType, FieldDefinition $fieldDefinition): string
    {
        $converter = new CamelCaseToSnakeCaseNameConverter(null, false);

        return sprintf(
            '%s%sInput',
            $converter->denormalize($contentType->identifier),
            $converter->denormalize($fieldDefinition->identifier)
        );
    }
}
```

## Resolver expressions

The following variables are available in the resolver's expression:

- `field` is the current field, as an extension of the API's field object that proxies properties requests to the field Value
- `content` is the resolved content item's `Content`
- `location` is the content item's resolved location. For more information, see [Querying Locations](../graphql_queries/index.md#querying-locations)
- `item` is the content together with its location `\Ibexa\GraphQL\Value\Item`

`RelationFieldValueBuilder` or `SelectionFieldValueBuilder` can be used as examples.
