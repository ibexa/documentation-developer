<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\Result\ComparisonResult;
use Ibexa\VersionComparison\Result\Value\StringComparisonResult;

final readonly class HelloWorldComparisonResult implements ComparisonResult
{
    public function __construct(private \Ibexa\VersionComparison\Result\Value\StringComparisonResult $stringDiff)
    {
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
