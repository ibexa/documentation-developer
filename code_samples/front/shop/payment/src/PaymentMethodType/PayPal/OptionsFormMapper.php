<?php

declare(strict_types=1);

namespace App\Form\Type;

use Ibexa\Contracts\Payment\PaymentMethod\Type\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class OptionsFormMapper implements OptionsFormMapperInterface
{
    public function createOptionsForm
    (
        string $name,
        FormBuilderInterface $builder,
        array $context = []
    ) : void {
        $builder->add($name, PayPalOptionsType::class);
    }
}
