<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Contracts\Core\Options\OptionsBag;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsValidatorError;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsValidatorInterface;

final class PercentOptionsValidator implements OptionsValidatorInterface
{
    public function validateOptions(OptionsBag $options): array
    {
        $min = $options->get('min');
        $max = $options->get('max');

        if ($min !== null && $max !== null && $min > $max) {
            return [
                new OptionsValidatorError('[max]', 'Maximum value should be greater than minimum value'),
            ];
        }

        return [];
    }
}
