<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use EzSystems\EzPlatformVersionComparison\Engine\FieldTypeComparisonEngine;
use EzSystems\EzPlatformVersionComparison\Engine\Value\StringComparisonEngine;
use EzSystems\EzPlatformVersionComparison\FieldType\FieldTypeComparisonValue;
use EzSystems\EzPlatformVersionComparison\Result\ComparisonResult;

final class HelloWorldComparisonEngine implements FieldTypeComparisonEngine
{
    /** @var \EzSystems\EzPlatformVersionComparison\Engine\Value\StringComparisonEngine */
    private $stringValueComparisonEngine;

    public function __construct(StringComparisonEngine $stringValueComparisonEngine)
    {
        $this->stringValueComparisonEngine = $stringValueComparisonEngine;
    }

    /**
     * @param \EzSystems\EzPlatformVersionComparison\FieldType\TextLine\Value $comparisonDataA
     * @param \EzSystems\EzPlatformVersionComparison\FieldType\TextLine\Value $comparisonDataB
     */
    public function compareFieldsTypeValues(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): ComparisonResult
    {
        return new HelloWorldComparisonResult(
            $this->stringValueComparisonEngine->compareValues($comparisonDataA->name, $comparisonDataB->name)
        );
    }

    public function shouldRunComparison(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): bool
    {
        return $comparisonDataA->name->value !== $comparisonDataB->name->value;
    }
}
