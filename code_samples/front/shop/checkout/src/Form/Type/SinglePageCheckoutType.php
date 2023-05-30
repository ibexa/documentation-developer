<?php

declare(strict_types=1);

namespace App\Form\Type;

use Ibexa\Bundle\Checkout\Form\Type\AddressType;
use Ibexa\Bundle\Payment\Form\Type\PaymentMethodChoiceType;
use Ibexa\Bundle\Shipping\Form\Type\ShippingMethodChoiceType;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class SinglePageCheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'payment_method',
            PaymentMethodChoiceType::class,
            [
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Payment Method',
            ],
        );

        $builder->add(
            'billing_address',
            AddressType::class,
            [
                'type' => 'billing',
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Billing Address',
            ]
        );

        $builder->add(
            'shipping_method',
            ShippingMethodChoiceType::class,
            [
                'cart' => $options['cart'],
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Shipping Method',
            ]
        );

        $builder->add(
            'shipping_address',
            AddressType::class,
            [
                'type' => 'shipping',
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Shipping Address',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'cart' => null,
        ]);

        $resolver->setAllowedTypes('cart', ['null', CartInterface::class]);
    }
}
