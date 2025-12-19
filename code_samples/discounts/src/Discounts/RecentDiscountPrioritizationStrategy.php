<?php declare(strict_types=1);

namespace App\Discounts;

use Ibexa\Contracts\Discounts\DiscountPrioritizationStrategyInterface;
use Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt;

final readonly class RecentDiscountPrioritizationStrategy implements DiscountPrioritizationStrategyInterface
{
    public function __construct(private DiscountPrioritizationStrategyInterface $inner)
    {
    }

    public function getOrder(): array
    {
        return array_merge(
            [new UpdatedAt()],
            $this->inner->getOrder()
        );
    }
}
