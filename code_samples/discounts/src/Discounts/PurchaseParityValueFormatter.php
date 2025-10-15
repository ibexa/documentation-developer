<?php

declare(strict_types=1);

namespace App\Discounts;

use Ibexa\Contracts\Discounts\Value\DiscountInterface;
use Ibexa\Contracts\Discounts\DiscountValueFormatterInterface;
use Money\Money;

final class PurchaseParityValueFormatter implements DiscountValueFormatterInterface
{
    public function format(DiscountInterface $discount, ?Money $money = null): string
    {

    }
}
