---
description: Discount Priority Sort Clause
edition: commerce
---

# Discount Priority Sort Clause

The `Priority` Sort Clause sorts search results by discount priority.

## Arguments

- (optional) `sortDirection` - `Priority` constant, either `Priority::SORT_ASC` or `Priority::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
        null,
        [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\Priority(AbstractSortClause::SORT_DESC)],
    ),
    10,
    static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
        $priorities = array_map(
            static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): int => $discount->getPriority(),
            $discountList->getDiscounts()
        );

        self::assertSame([10, 7, 3, 1], $priorities);
    }
```
