<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\Engine\FieldTypeComparisonEngine;
use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;
use Ibexa\Contracts\VersionComparison\Result\ComparisonResult;
use Ibexa\VersionComparison\Engine\Value\StringComparisonEngine;

final class HelloWorldComparisonEngine implements FieldTypeComparisonEngine
{
    /** @var \Ibexa\VersionComparison\Engine\Value\StringComparisonEngine */
    private \Ibexa\VersionComparison\Engine\Value\StringComparisonEngine $stringValueComparisonEngine;

    public function __construct(StringComparisonEngine $stringValueComparisonEngine)
    {
        $this->stringValueComparisonEngine = $stringValueComparisonEngine;
    }

    /**
     * @param \Ibexa\VersionComparison\FieldType\TextLine\Value $comparisonDataA
     * @param \Ibexa\VersionComparison\FieldType\TextLine\Value $comparisonDataB
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
