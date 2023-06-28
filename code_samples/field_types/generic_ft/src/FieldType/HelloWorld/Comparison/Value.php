<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;

class Value extends FieldTypeComparisonValue
{
    /** @var \Ibexa\VersionComparison\ComparisonValue\StringComparisonValue */
    public \Ibexa\VersionComparison\ComparisonValue\StringComparisonValue $name;
}
