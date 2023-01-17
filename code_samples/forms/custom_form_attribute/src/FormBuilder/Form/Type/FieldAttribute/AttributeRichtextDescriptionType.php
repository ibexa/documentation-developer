<?php declare(strict_types=1);

namespace App\FormBuilder\Form\Type\FieldAttribute;

use Ibexa\RichText\Form\Type\RichTextType;
use Symfony\Component\Form\AbstractType;

class AttributeRichtextDescriptionType extends AbstractType
{
    /**
     * @return string|null
     */
    public function getParent()
    {
        return RichTextType::class;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'field_configuration_attribute_richtext';
    }
}