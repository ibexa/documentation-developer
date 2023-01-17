<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueValidationError;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueValidatorInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionInterface;

final class PercentValueValidator implements ValueValidatorInterface
{
    public function validateValue(AttributeDefinitionInterface $attributeDefinition, $value): iterable
    {
        if ($value === null) {
            return [];
        }

        $errors = [];
        $options = $attributeDefinition->getOptions();

        $min = $options->get('min');
        if ($min !== null && $value < $min) {
            $errors[] = new ValueValidationError(null, 'Percentage should be greater or equal to %min%', [
                '%min%' => $min,
            ]);
        }

        $max = $options->get('max');
        if ($max !== null && $value > $max) {
            $errors[] = new ValueValidationError(null, 'Percentage should be lesser or equal to %max%', [
                '%max%' => $max,
            ]);
        }

        return $errors;
    }
}
