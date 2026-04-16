<?php declare(strict_types=1);

namespace App\GraphQL\Schema;

use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\Values\ContentType\FieldDefinition;
use Ibexa\Contracts\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionMapper;
use Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\DecoratingFieldDefinitionMapper;
use Ibexa\GraphQL\Schema\Domain\Content\NameHelper;

class RelationFieldDefinitionMapper extends DecoratingFieldDefinitionMapper implements FieldDefinitionMapper
{
    private NameHelper $nameHelper;

    private ContentTypeService $contentTypeService;

    public function __construct(
        FieldDefinitionMapper $innerMapper,
        NameHelper $nameHelper,
        ContentTypeService $contentTypeService
    ) {
        parent::__construct($innerMapper);
        $this->nameHelper = $nameHelper;
        $this->contentTypeService = $contentTypeService;
    }

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

        if ($this->isMultiple($fieldDefinition)) {
            $type = "[$type]";
        }

        return $type;
    }

    public function mapToFieldValueResolver(FieldDefinition $fieldDefinition): ?string
    {
        if (!$this->canMap($fieldDefinition)) {
            return parent::mapToFieldValueResolver($fieldDefinition);
        }

        $isMultiple = $this->isMultiple($fieldDefinition) ? 'true' : 'false';

        return sprintf('@=resolver("DomainRelationFieldValue", [field, %s])', $isMultiple);
    }

    protected function getFieldTypeIdentifier(): string
    {
        return 'ibexa_object_relation';
    }

    private function isMultiple(FieldDefinition $fieldDefinition): bool
    {
        $constraints = $fieldDefinition->getValidatorConfiguration();

        return isset($constraints['RelationListValueValidator'])
            && $constraints['RelationListValueValidator']['selectionLimit'] > 1;
    }
}
