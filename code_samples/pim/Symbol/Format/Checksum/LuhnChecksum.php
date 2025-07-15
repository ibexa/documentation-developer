<?php

declare(strict_types=1);

namespace App\PIM\Symbol\Format\Checksum;

use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionInterface;
use Ibexa\Contracts\ProductCatalogSymbolAttribute\Value\ChecksumInterface;

final class LuhnChecksum implements ChecksumInterface
{
    public function validate(AttributeDefinitionInterface $attributeDefinition, string $value): bool
    {
        $digits = $this->getDigits($value);

        $count = count($digits);
        $total = 0;
        for ($i = $count - 2; $i >= 0; $i -= 2) {
            $digit = $digits[$i];
            if ($i % 2 === 0) {
                $digit *= 2;
            }

            $total += $digit > 9 ? $digit - 9 : $digit;
        }

        $checksum = $digits[$count - 1];

        return $total + $checksum === 0;
    }

    /**
     * Returns an array of digits from the given value (skipping any formatting characters).
     *
     * @return int[]
     */
    private function getDigits(string $value): array
    {
        $chars = array_filter(
            str_split($value),
            static fn (string $char): bool => $char !== '-'
        );

        return array_map('intval', array_values($chars));
    }
}
