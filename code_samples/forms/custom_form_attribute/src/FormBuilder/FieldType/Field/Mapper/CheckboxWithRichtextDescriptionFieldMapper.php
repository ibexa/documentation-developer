<?php declare(strict_types=1);

namespace App\FormBuilder\FieldType\Field\Mapper;

use Ibexa\Contracts\FormBuilder\FieldType\Model\Field;
use Ibexa\FormBuilder\FieldType\Field\Mapper\GenericFieldMapper;

class CheckboxWithRichtextDescriptionFieldMapper extends GenericFieldMapper
{
    /**
     * {@inheritdoc}
     */
    protected function mapFormOptions(Field $field, array $constraints): array
    {
        $options = parent::mapFormOptions($field, $constraints);
        $options['label'] = $field->getAttributeValue('label');
        $options['richtext_description'] = $field->getAttributeValue('richtext_description');

        return $options;
    }
}
