<?php

declare(strict_types=1);

namespace App\Form\Type;

use Ibexa\Contracts\Core\Options\OptionsBag;
use Ibexa\Contracts\Payment\PaymentMethod\Type\OptionsValidatorError;
use Ibexa\Contracts\Payment\PaymentMethod\Type\OptionsValidatorInterface;

final class OptionsValidator implements OptionsValidatorInterface
{
    public function validateOptions(OptionsBag $options): array
    {
        $errors = [];
        if (empty ($options->get('base_url'))) {
            $errors[] = new OptionsValidatorError ('base_url', 'Base URL cannot be blank');
        }

        # ...

        return $errors;
    }
}
