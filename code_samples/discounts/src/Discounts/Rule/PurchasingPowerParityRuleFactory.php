<?php declare(strict_types=1);

namespace App\Discounts\Rule;

use Ibexa\Contracts\Discounts\Value\DiscountRuleInterface;
use Ibexa\Discounts\Repository\DiscountRule\DiscountRuleFactoryInterface;

final class PurchasingPowerParityRuleFactory implements DiscountRuleFactoryInterface
{
    public function createDiscountRule(?array $expressionValues): DiscountRuleInterface
    {
        return new PurchasingPowerParityRule($expressionValues['power_parity_map'] ?? null);
    }
}
