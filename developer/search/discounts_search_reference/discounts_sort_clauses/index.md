# Discounts Search Sort Clauses reference

Sort Clauses available for Discounts search

Editions: Commerce

Sort Clauses are found in the [`Ibexa\Contracts\Discounts\Value\Query\SortClause`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-discounts-value-query-sortclause.html) namespace, implementing the [`Ibexa\Contracts\Discounts\Value\Query\SortClauseInterface`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClauseInterface.php) interface:

| Name                                                                                                                                                                     | Description                                                                                                                            |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\CreatedAt`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/CreatedAt.php)                           | Sort by discount's creation date                                                                                                       |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\EndDate`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/EndDate.php)                               | Sort by discount's end date                                                                                                            |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Id`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Id.php)                                         | Sort by discount's database ID                                                                                                         |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Identifier`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Identifier.php)                         | Sort by discount identifier                                                                                                            |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\OverridePrioritization`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/OverridePrioritization.php) | Sort prioritizing discounts with discount code over automatic ones                                                                     |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Priority`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Priority.php)                             | Sort by discount priority                                                                                                              |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\StartDate`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/StartDate.php)                           | Sort by discount start date                                                                                                            |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\Type`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/Type.php)                                     | Sort by the place where the discount activates: catalog or cart. When sorting with ascending order, cart discounts are returned first. |
| [`Ibexa\Contracts\Discounts\Value\Query\SortClause\UpdatedAt`](../../../../../../ibexa/discounts/src/contracts/Value/Query/SortClause/UpdatedAt.php)                           | Sort by discount modification date                                                                                                     |

The following example shows how to use them to sort the searched discounts:

```php
<?php

declare(strict_types=1);

use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\FieldValueCriterion;
use Ibexa\Contracts\Discounts\Value\Query\Criterion;
use Ibexa\Contracts\Discounts\Value\Query\DiscountQuery;
use Ibexa\Contracts\Discounts\Value\Query\SortClause;

$now = new DateTimeImmutable();

$query = new DiscountQuery(
    new Criterion\LogicalAnd(
        new Criterion\IsEnabledCriterion(),
        new Criterion\StartDateCriterion($now, FieldValueCriterion::COMPARISON_LTE),
        new Criterion\LogicalOr(
            new Criterion\EndDateCriterion($now, FieldValueCriterion::COMPARISON_GTE),
            new Criterion\EndDateCriterion(null, FieldValueCriterion::COMPARISON_EQ)
        ),
    ),
    [
        new SortClause\Type(),
        new SortClause\Priority(),
        new SortClause\CreatedAt(),
    ]
);

/** @var \Ibexa\Contracts\Discounts\DiscountServiceInterface $discountService */
$results = $discountService->findDiscounts($query);
```

The returned active discounts are sorted by:

- the place where they activate: catalog or cart, with `cart` discounts returned first
- priority (descending)
- creation date (descending)

You can change the default sorting order by using the `SORT_ASC` and `SORT_DESC` constants from [`Ibexa\Contracts\CoreSearch\Values\Query\AbstractSortClause`](../../../../../../ibexa/core-search/src/contracts/Values/Query/AbstractSortClause.php).
