<?php

declare(strict_types=1);

namespace App\Discounts\Rule;

use Ibexa\Contracts\Discounts\DiscountValueFormatterInterface;
use Ibexa\Contracts\Discounts\Value\DiscountRuleInterface;
use Money\Money;

final class PurchaseParityValueFormatter implements DiscountValueFormatterInterface
{
    public function format(DiscountRuleInterface $discountRule, ?Money $money = null): string
    {
        return 'Regional discount';
    }
}
