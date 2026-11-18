<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;
use Ibexa\VersionComparison\ComparisonValue\StringComparisonValue;

class Value extends FieldTypeComparisonValue
{
    /** @var StringComparisonValue */
    public StringComparisonValue $name;
}
