---
description: Discount Identifier Search Criterion
edition: commerce
---

# Discount Identifier Criterion

The `Identifier` Search Criterion searches for discounts based on the discount identifier.

## Arguments

- `identifier` - string that represents the discount identifier

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Discounts\Value\Query\Criterion\IdentifierCriterion('summer-sale');

$discountQuery = new DiscountQuery($criteria);
```
