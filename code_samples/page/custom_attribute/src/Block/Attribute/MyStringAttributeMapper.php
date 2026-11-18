<?php declare(strict_types=1);

namespace App\Block\Attribute;

use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Attribute\FormTypeMapper\AttributeFormTypeMapperInterface;
use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition;
use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockDefinition;
use Symfony\Component\Form\FormBuilderInterface;

class MyStringAttributeMapper implements AttributeFormTypeMapperInterface
{
    /**
     * @param FormBuilderInterface $formBuilder
     * @param BlockDefinition $blockDefinition
     * @param BlockAttributeDefinition $blockAttributeDefinition
     * @param array $constraints
     *
     * @return FormBuilderInterface
     *
     * @throws \Exception
     */
    public function map(
        FormBuilderInterface $formBuilder,
        BlockDefinition $blockDefinition,
        BlockAttributeDefinition $blockAttributeDefinition,
        array $constraints = []
    ): FormBuilderInterface {
        return $formBuilder->create(
            'value',
            MyStringAttributeType::class,
            [
                'constraints' => $constraints,
            ]
        );
    }
}
