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
