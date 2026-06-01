<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\Engine\FieldTypeComparisonEngine;
use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;
use Ibexa\Contracts\VersionComparison\Result\ComparisonResult;

final readonly class HelloWorldComparisonEngine implements FieldTypeComparisonEngine
{
    public function __construct(private \Ibexa\VersionComparison\Engine\Value\StringComparisonEngine $stringValueComparisonEngine)
    {
    }

    /**
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataA
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataB
     */
    public function compareFieldsTypeValues(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): ComparisonResult
    {
        return new HelloWorldComparisonResult(
            $this->stringValueComparisonEngine->compareValues($comparisonDataA->name, $comparisonDataB->name)
        );
    }

    /**
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataA
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataB
     */
    public function shouldRunComparison(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): bool
    {
        return $comparisonDataA->name->value !== $comparisonDataB->name->value;
    }
}
