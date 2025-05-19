---
description: Discount UpdatedAt Sort Clause
edition: commerce
---

# Discount UpdatedAt Sort Clause

The `UpdatedAt` Sort Clause sorts search results by the date and time when the discount's parameters were updated.

## Arguments

- (optional) `sortDirection` - `UpdatedAt` constant, either `UpdatedAt::SORT_ASC` or `UpdatedAt::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
    null,
    [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt(\Ibexa\Contracts\CoreSearch\Values\Query\AbstractSortClause::SORT_ASC)],
),
10,
static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
    $timestamps = array_map(
        static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): DateTimeInterface => $discount->getUpdatedAt(),
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
