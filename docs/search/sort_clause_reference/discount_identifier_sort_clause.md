---
description: Discount Identifier Sort Clause
edition: commerce
---

# Discount Identifier Sort Clause

The `Identifier` Sort Clause sorts search results by discount identifier.

## Arguments

- (optional) `sortDirection` - `Identifier` constant, either `Identifier::SORT_ASC` or `Identifier::SORT_DESC`

## Example

``` php
new \Ibexa\Contracts\Discounts\Value\Query\DiscountQuery(
        null,
        [new \Ibexa\Contracts\Discounts\Value\Query\SortClause\Identifier(AbstractSortClause::SORT_DESC)],
    ),
    10,
    static function (\Ibexa\Contracts\Discounts\Value\DiscountListInterface $discountList): void {
        $identifiers = array_map(
            static fn (\Ibexa\Contracts\Discounts\Value\DiscountInterface $discount): string => $discount->getIdentifier(),
            $discountList->getDiscounts()
        );

        self::assertSame([foo, bar, tic, tac], $identifiers);
    }
```
