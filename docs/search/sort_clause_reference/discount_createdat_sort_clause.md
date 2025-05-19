---
description: Discount CreatedAt Sort Clause
edition: commerce
---

# Discount CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time when the discount was created.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
    null,
    [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\CreatedAt(\Ibexa\Contracts\CoreSearch\Values\Query\AbstractSortClause::SORT_ASC)],
),
10,
static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
    $timestamps = array_map(
        static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): DateTimeInterface => $discount->getCreatedAt(),
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
