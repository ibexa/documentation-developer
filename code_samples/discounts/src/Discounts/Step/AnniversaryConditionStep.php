<?php declare(strict_types=1);

namespace App\Discounts\Step;

use Ibexa\Contracts\Discounts\Admin\Form\Data\AbstractDiscountStep;

final class AnniversaryConditionStep extends AbstractDiscountStep
{
    public const string IDENTIFIER = 'anniversary_condition_step';

    public function __construct(public bool $enabled = false, public int $tolerance = 0)
    {
    }
}
