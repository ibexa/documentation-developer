<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use App\Form\Type\Point2DSettingsType;
use App\Form\Type\Point2DType;
use Ibexa\Contracts\Core\Repository\Values\ContentType\FieldDefinition;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Ibexa\Contracts\Core\FieldType\Value;
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Ibexa\AdminUi\Form\Data\FieldDefinitionData;
use Symfony\Component\Form\FormInterface;
use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Ibexa\AdminUi\FieldType\FieldDefinitionFormMapperInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface, FieldDefinitionFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }

    public function getSettingsSchema(): array
    {
        return [
            'format' => [
                'type' => 'string',
                'default' => '(%x%, %y%)',
            ],
        ];
    }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data)
    {
        $definition = $data->fieldDefinition;
        $fieldForm->add('value', Point2DType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName()
        ]);
    }

    public function mapFieldDefinitionForm(FormInterface $fieldDefinitionForm, FieldDefinitionData $data): void
    {
        $fieldDefinitionForm->add('fieldSettings', Point2DSettingsType::class, [
            'label' => false
        ]);
    }
}
