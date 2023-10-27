<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use eZ\Publish\SPI\FieldType\Value as SPIValue;
use EzSystems\EzPlatformVersionComparison\ComparisonValue\StringComparisonValue;
use EzSystems\EzPlatformVersionComparison\FieldType\Comparable as ComparableInterface;
use EzSystems\EzPlatformVersionComparison\FieldType\FieldTypeComparisonValue;

final class Comparable implements ComparableInterface
{
    public function getDataToCompare(SPIValue $value): FieldTypeComparisonValue
    {
        return new Value([
            'name' => new StringComparisonValue([
                'value' => $value->getName(),
            ]),
        ]);
    }
}
