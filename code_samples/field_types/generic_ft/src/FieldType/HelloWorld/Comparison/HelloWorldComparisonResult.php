<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\Result\ComparisonResult;
use Ibexa\VersionComparison\Result\Value\StringComparisonResult;

final class HelloWorldComparisonResult implements ComparisonResult
{
    /** @var \Ibexa\VersionComparison\Result\Value\StringComparisonResult */
    private \Ibexa\VersionComparison\Result\Value\StringComparisonResult $stringDiff;

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
