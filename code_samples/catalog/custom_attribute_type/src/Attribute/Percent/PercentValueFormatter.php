<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormatterInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeInterface;
use NumberFormatter;

final class PercentValueFormatter implements ValueFormatterInterface
{
    public function formatValue(AttributeInterface $attribute, array $parameters = []): ?string
    {
        $value = $attribute->getValue();
        if ($value === null) {
            return null;
        }

        $formatter = $parameters['formatter'] ?? null;
        if ($formatter === null) {
            $formatter = new NumberFormatter('', NumberFormatter::PERCENT);
        }

        return $formatter->format($value);
    }
}
