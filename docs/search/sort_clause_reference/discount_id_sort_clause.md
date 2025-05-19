---
description: Discount Id Sort Clause
edition: commerce
---

# Discount Id Sort Clause

The `Id` Sort Clause sorts search results by discount ID.

## Arguments

- (optional) `sortDirection` - `Id` constant, either `Id::SORT_ASC` or `Id::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
        null,
        [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\Id(AbstractSortClause::SORT_DESC)],
    ),
    10,
    static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
        $ids = array_map(
            static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): int => $discount->getId(),
            $discountList->getDiscounts()
        );

        self::assertSame([10, 7, 3, 1], $ids);
    }
```
