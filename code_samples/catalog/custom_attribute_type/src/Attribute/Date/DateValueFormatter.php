<?php

declare(strict_types=1);

namespace App\Attribute\Date;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormatterInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeInterface;
use IntlDateFormatter;
use DateTime;
use Locale;

final class DateValueFormatter implements ValueFormatterInterface
{
    public function formatValue(AttributeInterface $attribute, array $parameters = []): ?string
    {
        $value = $attribute->getValue();
        if ($value === null) {
            return null;
        }

        $formatter = new IntlDateFormatter($parameters['locale'] ?? Locale::getDefault(), IntlDateFormatter::LONG, IntlDateFormatter::NONE);

        return $formatter->format(new DateTime($value['date']));
    }
}
