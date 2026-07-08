<?php declare(strict_types=1);

namespace App\Discounts;

use Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface;
use Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt;

final class RecentDiscountPrioritizationStrategy implements DiscountPrioritizationStrategyInterface
{
    private DiscountPrioritizationStrategyInterface $inner;

    public function __construct(DiscountPrioritizationStrategyInterface $inner)
    {
        $this->inner = $inner;
    }

    public function getOrder(): array
    {
        return array_merge(
            [new UpdatedAt()],
            $this->inner->getOrder()
        );
    }
}
