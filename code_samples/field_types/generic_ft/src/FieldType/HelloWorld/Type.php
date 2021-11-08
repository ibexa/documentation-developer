<?php

namespace App\FieldType\HelloWorld;

use App\Form\Type\HelloWorldType;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'hello_world';
    }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->fieldDefinition;

        $fieldForm->add('value', HelloWorldType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName()
        ]);
    }
}
