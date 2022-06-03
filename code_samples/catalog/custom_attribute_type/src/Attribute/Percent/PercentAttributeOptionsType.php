<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PercentAttributeOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('min', PercentType::class, [
            'disabled' => $options['translation_mode'],
            'label' => "Minimum Value",
            'required' => false,
        ]);

        $builder->add('max', PercentType::class, [
            'disabled' => $options['translation_mode'],
            'label' => "Maximum Value",
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_mode' => false,
        ]);
        $resolver->setAllowedTypes('translation_mode', 'bool');
    }
}
