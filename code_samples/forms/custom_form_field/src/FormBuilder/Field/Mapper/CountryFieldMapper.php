<?php declare(strict_types=1);

namespace App\FormBuilder\Field\Mapper;

use Ibexa\Contracts\FormBuilder\FieldType\Model\Field;
use Ibexa\FormBuilder\FieldType\Field\Mapper\GenericFieldMapper;

class CountryFieldMapper extends GenericFieldMapper
{
    protected function mapFormOptions(Field $field, array $constraints): array
    {
        $options = parent::mapFormOptions($field, $constraints);
        $options['label'] = $field->getAttributeValue('label');
        $options['help'] = $field->getAttributeValue('help');

        return $options;
    }
}
