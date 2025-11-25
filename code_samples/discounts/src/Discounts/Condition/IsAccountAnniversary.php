<?php declare(strict_types=1);

namespace App\Discounts\Condition;

use Ibexa\Contracts\Discounts\Value\DiscountConditionInterface;
use Ibexa\Discounts\Value\AbstractDiscountExpressionAware;

final class IsAccountAnniversary extends AbstractDiscountExpressionAware implements DiscountConditionInterface
{
    public const IDENTIFIER = 'is_account_anniversary';

    public function __construct(?int $tolerance = null)
    {
        parent::__construct([
            'tolerance' => $tolerance ?? 0,
        ]);
    }

    public function getTolerance(): int
    {
        return $this->getExpressionValue('tolerance');
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function getExpression(): string
    {
        return 'is_anniversary(current_user_registration_date, tolerance)';
    }
}
