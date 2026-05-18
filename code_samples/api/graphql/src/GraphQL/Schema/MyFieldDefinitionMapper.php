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
