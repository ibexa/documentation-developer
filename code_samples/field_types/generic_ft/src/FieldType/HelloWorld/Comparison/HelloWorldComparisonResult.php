<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use EzSystems\EzPlatformVersionComparison\Result\ComparisonResult;
use EzSystems\EzPlatformVersionComparison\Result\Value\StringComparisonResult;

final class HelloWorldComparisonResult implements ComparisonResult
{
    /** @var \EzSystems\EzPlatformVersionComparison\Result\Value\StringComparisonResult */
    private $stringDiff;

    public function __construct(StringComparisonResult $stringDiff)
    {
        $this->stringDiff = $stringDiff;
    }

    public function getHelloWorldDiff(): StringComparisonResult
    {
        return $this->stringDiff;
    }

    public function isChanged(): bool
    {
        return $this->stringDiff->isChanged();
    }
}
