<?php

declare(strict_types=1);

namespace App\Attribute\Date;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormMapperInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionAssignmentInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class DateValueFormMapper implements ValueFormMapperInterface
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
            'block_prefix' => 'date_attribute_value',
            'required' => $assignment->isRequired(),
            'widget' => 'single_text',
            'input' => 'datetime',
        ];

        if ($assignment->isRequired()) {
            $options['constraints'] = [
                new Assert\NotBlank(),
            ];
        }

        $builder->add($name, DateType::class, $options);
    }
}
