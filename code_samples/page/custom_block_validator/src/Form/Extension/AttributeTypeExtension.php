<?php declare(strict_types=1);

use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition;
use Ibexa\PageBuilder\Form\Type\Attribute\AttributeType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class AttributeTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var BlockAttributeDefinition $attributeDefinition */
        $attributeDefinition = $options['block_attribute_definition'];

        if (isset($attributeDefinition->getConstraints()['custom_not_blank'])) {
            $builder->setRequired(true);
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            AttributeType::class,
        ];
    }
}
