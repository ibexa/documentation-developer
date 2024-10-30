<?php declare(strict_types=1);

namespace App\Form\Type;

use Ibexa\Bundle\ConnectorAi\Form\Type\ActionConfiguration\ActionConfigurationOptions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TextToTextOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('prompt', TextareaType::class, [
            'required' => false,
            'disabled' => $options['translation_mode'],
        ]);

        $builder->add('system_prompt', TextareaType::class, [
            'required' => false,
            'disabled' => $options['translation_mode'],
            'label' => 'System message',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'ibexa_connector_ai',
            'translation_mode' => false,
        ]);

        $resolver->setAllowedTypes('translation_mode', 'bool');
    }

    public function getParent(): string
    {
        return ActionConfigurationOptions::class;
    }
}
