---
description: Discount StartDate Sort Clause
edition: commerce
---

# Discount StartDate Sort Clause

The `StartDate` Sort Clause sorts search results by the discount's start date and time.

## Arguments

- (optional) `sortDirection` - `StartDate` constant, either `StartDate::SORT_ASC` or `StartDate::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
    null,
    [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\StartDate(AbstractSortClause::SORT_DESC)],
),
10,
static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
    $timestamps = array_map(
        static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): DateTimeInterface => $discount->getStartDate(),
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
