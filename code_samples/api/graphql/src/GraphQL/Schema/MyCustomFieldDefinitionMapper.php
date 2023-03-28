<?php
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