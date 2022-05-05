<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeDefinitionOptions;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class PercentOptionsFormMapper implements OptionsFormMapperInterface
{
    public function createOptionsForm(string $name, FormBuilderInterface $builder, array $context = []): void
    {
        $builder->add($name, PercentAttributeOptionsType::class, [
            'constraints' => [
                new AttributeDefinitionOptions(['type' => $context['type']]),
            ],
            'translation_mode' => $context['translation_mode'],
        ]);
    }
}
