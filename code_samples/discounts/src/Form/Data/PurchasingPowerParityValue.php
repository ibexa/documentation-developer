<?php declare(strict_types=1);

namespace App\Form\Data;

use Ibexa\Contracts\Discounts\Admin\Form\Data\AbstractDiscountValue;

final class PurchasingPowerParityValue extends AbstractDiscountValue
{
    public string $value;
}
