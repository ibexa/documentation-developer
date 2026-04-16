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
