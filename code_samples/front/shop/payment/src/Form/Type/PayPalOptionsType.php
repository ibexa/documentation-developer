<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class PayPalOptionsType extends AbstractType 
{ 
    public function buildForm(FormBuilderInterface $builder, array $options): void 
    { 
        builder->add( 
            'base_url', 
            UrlType::class, 
            [ 
                'constraints' => [ 
                    new NotBlank(),
                ]
            ]
        );

        # ...
    }
}
