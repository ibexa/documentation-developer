<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use App\Form\Type\Point2DSettingsType;
use App\Form\Type\Point2DType;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;
use eZ\Publish\SPI\FieldType\Value;
use EzSystems\EzPlatformContentForms\Data\Content\FieldData;
use EzSystems\EzPlatformAdminUi\Form\Data\FieldDefinitionData;
use Symfony\Component\Form\FormInterface;
use EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface;
use EzSystems\EzPlatformAdminUi\FieldType\FieldDefinitionFormMapperInterface;

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
