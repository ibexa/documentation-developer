<?php declare(strict_types=1);

namespace App\Discounts\Step;

use Ibexa\Contracts\Discounts\Admin\Form\Data\AbstractDiscountStep;

final class AnniversaryConditionStep extends AbstractDiscountStep
{
    public const IDENTIFIER = 'anniversary_condition_step';

    public bool $enabled;

    public int $tolerance;

    public function __construct(bool $enabled = false, int $tolerance = 0)
    {
        $this->enabled = $enabled;
        $this->tolerance = $tolerance;
    }
}
