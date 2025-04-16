---
description: Discount EndDate Sort Clause
edition: commerce
---

# Discount EndDate Sort Clause

The `EndDate` Sort Clause sorts search results by the discount's end date and time.

## Arguments

- (optional) `sortDirection` - `EndDate` constant, either `EndDate::SORT_ASC` or `EndDate::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
    null,
    [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\EndDate(AbstractSortClause::SORT_DESC)],
),
10,
static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
    $timestamps = array_map(
        static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): DateTimeInterface => $discount->getEndDate(),
        $discountList->getDiscounts()
    );

    self::assertEquals(
        [
            new DateTimeImmutable('2024-11-20 14:07:04'),
            new DateTimeImmutable('2024-11-20 14:07:04'),
        ],
        $timestamps
    );
}
```
