<?php

declare(strict_types=1);

namespace App\Attribute\Percent\Form;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeValue;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormMapperInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionAssignmentInterface;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class PercentValueFormMapper implements ValueFormMapperInterface
{
    public function createValueForm(
        string $name,
        FormBuilderInterface $builder,
        AttributeDefinitionAssignmentInterface $assignment,
        array $context = []
    ): void {
        $definition = $assignment->getAttributeDefinition();

        $options = [
            'disabled' => $context['translation_mode'] ?? false,
            'label' => $definition->getName(),
            'block_prefix' => 'percentage_attribute_value',
            'required' => $assignment->isRequired(),
            'constraints' => [
                new AttributeValue([
                    'definition' => $definition,
                ]),
            ],
        ];

        if ($assignment->isRequired()) {
            $options['constraints'] = [
                new Assert\NotBlank(),
            ];
        }

        $builder->add($name, PercentType::class, $options);
    }
}