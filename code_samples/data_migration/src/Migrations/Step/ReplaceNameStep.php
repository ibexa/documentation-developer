<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Migrations\Step;

use Ibexa\Migration\ValueObject\Step\StepInterface;

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
