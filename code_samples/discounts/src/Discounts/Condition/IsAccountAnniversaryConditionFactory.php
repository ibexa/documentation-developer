<?php declare(strict_types=1);

namespace App\Discounts\Condition;

use Ibexa\Contracts\Discounts\Value\DiscountConditionInterface;
use Ibexa\Discounts\Repository\DiscountCondition\DiscountConditionFactoryInterface;

final class IsAccountAnniversaryConditionFactory implements DiscountConditionFactoryInterface
{
    public function createDiscountCondition(?array $expressionValues): DiscountConditionInterface
    {
        return new IsAccountAnniversary(
            $expressionValues['tolerance'] ?? null
        );
    }
}
