<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Form\Type;

use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CustomShippingMethodOptionsType extends AbstractType implements TranslationContainerInterface
{
    public function getBlockPrefix(): string
    {
        return 'ibexa_shipping_method_custom';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('customer_identifier', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['translation_mode' => false]);
        $resolver->setAllowedTypes('translation_mode', 'bool');
    }

    public static function getTranslationMessages(): array
    {
        return [
            Message::create('ibexa.shipping_types.custom.name', 'ibexa_shipping')->setDesc('Custom'),
        ];
    }
}