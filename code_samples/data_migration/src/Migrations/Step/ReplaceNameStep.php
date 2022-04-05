<?php

declare(strict_types=1);

namespace App\Migrations\Step;

use Ibexa\Platform\Migration\ValueObject\Step\StepInterface;

final class ReplaceNameStep implements StepInterface
{
    private string $replacement;

    public function __construct(?string $replacement = null)
    {
        $this->replacement = $replacement ?? 'New Company Name';
    }

    public function getReplacement(): string
    {
        return $this->replacement;
    }
}
