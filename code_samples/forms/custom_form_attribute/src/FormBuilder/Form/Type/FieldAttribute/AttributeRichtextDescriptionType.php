<?php declare(strict_types=1);

namespace App\FormBuilder\Form\Type\FieldAttribute;

use Ibexa\FieldTypeRichText\Form\Type\RichTextType;
use Symfony\Component\Form\AbstractType;

class AttributeRichtextDescriptionType extends AbstractType
{
    /**
     * @return string|null
     */
    #[\Override]
    public function getParent(): ?string
    {
        return RichTextType::class;
    }

    /**
     * @return string
     */
    #[\Override]
    public function getBlockPrefix(): string
    {
        return 'field_configuration_attribute_richtext';
    }
}
