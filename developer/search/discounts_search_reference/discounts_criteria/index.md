# Discounts Search Criterion reference

Search Criteria available for Discounts search

Editions: Commerce

Search Criteria are found in the [`Ibexa\Contracts\Discounts\Value\Query\Criterion`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-discounts-value-query-criterion.html) namespace, implementing the [`Ibexa\Contracts\Discounts\Value\Query\CriterionInterface`](../../../../../../ibexa/discounts/src/contracts/Value/Query/CriterionInterface.php) interface:

| Criterion                                                                                                                                                         | Description                                                                                                                                                                                          |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatedAtCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/CreatedAtCriterion.php)   | Find discounts with given creation date                                                                                                                                                              |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatorCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/CreatorCriterion.php)       | Find discounts created by specific users                                                                                                                                                             |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\EndDateCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/EndDateCriterion.php)       | Find discounts by their end date. For permanent discounts, the end date is set to `null`                                                                                                             |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IndexedAtCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/IndexedAtCriterion.php)   | Find discounts based on the date and time when they were indexed                                                                                                                                     |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IdentifierCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/IdentifierCriterion.php) | Find discounts by their identifier                                                                                                                                                                   |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\IsEnabledCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/IsEnabledCriterion.php)   | Find discounts by their status                                                                                                                                                                       |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalAnd`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/LogicalAnd.php)                   | Composite criterion to group multiple criteria using the AND condition                                                                                                                               |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalOr`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/LogicalOr.php)                     | Composite criterion to group multiple criteria using the OR condition                                                                                                                                |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\NameCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/NameCriterion.php)             | Find discounts by their name                                                                                                                                                                         |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\PriorityCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/PriorityCriterion.php)     | Find discounts by their priority                                                                                                                                                                     |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\StartDateCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/StartDateCriterion.php)   | Find discounts with given start date                                                                                                                                                                 |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\TypeCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/TypeCriterion.php)             | Find cart or catalog discounts by using constants from the [`Ibexa\Contracts\Discounts\Value\DiscountType`](../../../../../../ibexa/discounts/src/contracts/Value/DiscountType.php) class |
| [`Ibexa\Contracts\Discounts\Value\Query\Criterion\UpdatedAtCriterion`](../../../../../../ibexa/discounts/src/contracts/Value/Query/Criterion/UpdatedAtCriterion.php)   | Find discounts based on the date and time when they were updated                                                                                                                                     |

You can use the [FieldValueCriterion's constants](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php) like `FieldValueCriterion::COMPARISON_CONTAINS` or `FieldValueCriterion::COMPARISON_STARTS_WITH` to specify the operator for the condition.

Use the `limit` and `offset` properties of [`Ibexa\Contracts\Discounts\Value\Query\DiscountQuery`](../../../../../../ibexa/discounts/src/contracts/Value/Query/DiscountQuery.php) to limit the number of results and implement pagination.

The following example shows how you can use the criteria to find all the currently active discounts:

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

The criteria limit the result set to discounts matching all of the conditions listed below:

- discount must be enabled
- discount start date is not after the current date
- discount end date is not before the current date or is not specified
