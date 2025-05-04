---
description: Discount Type Sort Clause
edition: commerce
---

# Discount Type Sort Clause

The `Type` Sort Clause sorts search results by discount type.

## Arguments

- (optional) `sortDirection` - `Type` constant, either `Type::SORT_ASC` or `Type::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
        null,
        [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\Type(AbstractSortClause::SORT_DESC)],
    ),
    10,
    static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
        $types = array_map(
            static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): string => $discount->getType(),
            $discountList->getDiscounts()
        );

        self::assertSame([catalog, cart], $types);
    }
```
