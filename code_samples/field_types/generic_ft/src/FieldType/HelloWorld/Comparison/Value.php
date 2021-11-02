<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;

class Value extends FieldTypeComparisonValue
{
    /** @var \Ibexa\Contracts\VersionComparison\FieldType\StringComparisonValue */
    public $name;
}
