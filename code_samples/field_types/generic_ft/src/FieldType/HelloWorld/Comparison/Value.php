<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use EzSystems\EzPlatformVersionComparison\FieldType\FieldTypeComparisonValue;

class Value extends FieldTypeComparisonValue
{
    /** @var \EzSystems\EzPlatformVersionComparison\ComparisonValue\StringComparisonValue */
    public $name;
}
