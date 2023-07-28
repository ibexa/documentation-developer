<?php declare(strict_types=1);

namespace App\GraphQL\Schema;

use Ibexa\Contracts\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionMapper;
use Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper;

class MyCustomFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper
{
    protected function getFieldTypeIdentifier(): string
    {
        return 'my_custom_field_type';
    }
}
